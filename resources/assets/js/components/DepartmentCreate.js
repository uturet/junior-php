import React from 'react';
import WidgetInterface from './WidgetInterface';


import CreationForm from './CreationElements/CreationForm';
import Button from './CreationElements/Button';
import Select from './CreationElements/Select';
import Input from './CreationElements/Input';
import WidgetSidebar from './WidgetElements/WidgetSidebar';
import ModelList from './WidgetElements/ModelList';
import Hierarchy from './WidgetElements/Hierarchy';
import Model from './WidgetElements/Model';
import Card from './WidgetElements/Card';


class DepartmentCreate extends WidgetInterface {

    constructor(props) {
        super(props);
        this.state = Object.assign(this.state, {
            name: window.selectedCollection ? window.selectedCollection.name : '',
            headEmployee: window.selectedCollection ?
                window.selectedCollection.head_employee_id ? window.selectedCollection.head_employee_id :
                    'null' : 'null',
            description: window.selectedCollection ? window.selectedCollection.description : '',
            employeeMarker:  window.selectedCollection ? 'edit' : undefined,
            managinDepartmentsURL: 'managing-departments/widget',
            dataItems: {
                name: 'name',
                headEmployee: 'head_employee_id',
                description: 'description',
            },
        });
    }

    componentDidMount() {
        this.loadManagingDepartments()
    }

    downState() {
        this.setState({
            name: '',
            headEmployee: 'null',
            wage: '',
            description: '',
            exceptionModelID: '',
            collection: null,
            archive: null,
            unformedEmployeesCollection: null
        });

        this.loadManagingDepartments();
    }

    downSelected(nullValue, model) {
        if (model.employee) {
            if (model.employee.id === this.state.headEmployee) {
                this.setState({
                    headEmployee: nullValue,
                    employeeMarker: nullValue,
                });
            }
        }
    }

    getValidation() {
        const { name, description, headEmployee, employeeMarker } = this.state;
        let validate = ['type', 'name', 'button'];

        if (name) {
            validate = ['type', 'name', 'description', 'button'];
        }

        const validation = {};
        let type = null;
        validate.forEach((e) => {
            validation[e] = (this.state[e] === 'null') || !this.state[e] ? 'is-invalid' : '';
        });

        validation.button = { isDisabled: true };

        if (name && description) {
            if (headEmployee !== 'null') {
                if (employeeMarker === 'collection') {
                    validation.button = {
                        isDisable: false,
                        alert: (<p>Сотрудник будет <b>переведен</b> на управление новым подразделением.
                            А <b>подчененные</b> переведены под управление его руководителя</p>) };
                    type = 1;
                } else if (employeeMarker === 'edit') {
                    validation.button = { isDisabled: false };
                    type = 0;
                } else if (employeeMarker !== 'collection') {
                    validation.button.alert = (<p>Сотрудник должен быть сперва <b>нанят</b> на работу</p>);
                    type = 0;
                }
            } else {
                validation.button = { isDisable: false };
                type = 0;
            }
        }

        validation.button.label = window.selectedCollection ? 'Обновить Подразделение' : 'Создать Подразделение';

        return [validation, type];
    }

    render() {
        const {
            collection,
            archive,
            unformedEmployeesCollection,
            departmentSubCollectionURL,
            employeeSubCollectionURL,
            name,
            headEmployee,
            dataItems,
            description } = this.state;
        const [validation, type] = this.getValidation();
        const data = { _token: window.csrf, type: type }
        const state = this.state;
        const mainCollection = [];

        Object.keys(dataItems).forEach(key => {
            if (state[key] && state[key] !== 'null') {
                data[dataItems[key]] = state[key];
            }
        });

        if (collection) { mainCollection.push(...collection); }
        if (unformedEmployeesCollection) { mainCollection.push(...unformedEmployeesCollection); }
        if (archive) { mainCollection.push(...archive); }

        const modelList = this.collectionToModelList(mainCollection, false);

        const put = !!window.selectedCollection;

        const form = (
            <CreationForm
                validation={validation}
                modelList={modelList}>

                <Input
                    stateName={'name'}
                    label={'Название'}
                    name={'name'}
                    value={name}
                    setValue={value => this.setName(value)}
                    type={'text'} />

                <Select
                    stateName={'headEmployee'}
                    label={'Управляющий'}
                    name={'head_employee_id'}
                    modelName={'employee'}
                    modelList={modelList}
                    value={headEmployee}
                    setMarker={marker => this.setEmployeeMarker(marker)}
                    setValue={value => this.setHeadEmployee(value)}
                    defaultValue={window.selectedCollection ? window.selectedCollection.employee : null}
                    chained />

                <Input
                    stateName={'description'}
                    label={'Описание'}
                    name={'description'}
                    value={description}
                    setValue={value => this.setDescription(value)}
                    type={'text'} />

                <Button
                    submitForm={() => this.submitForm(
                        data,
                        document.URL.replace(put ? '/edit' : '/create', ''),
                        put,
                        () => this.downState()
                    )}
                    stateName={'button'} />

            </CreationForm>
        );

        const cardList = (
            <div className={'table-responsive'} style={{ maxHeight: '-webkit-fill-available' }}>
                <Card
                    collection={!!collection}
                    loadCollection={() => this.loadManagingDepartments()}
                    loadable
                    title={'Иерархия подразделений'}
                    label={'Иерархия Подразделений'}>
                    <ModelList
                        collection={this.collectionToHierarchyList(collection)}
                        modelName='department'
                        hierarchy>
                        <Hierarchy
                            toggleSelectedElem={path => this.toggleSelectedElem(path)}
                            urlExample={departmentSubCollectionURL}
                            loadSubCollection={(url, callback) => this.loadSubCollection(url, callback)}
                            insertCollection={(path, data) => this.insertCollection(path, data)}
                            toggleDisabled={path => this.toggleDisabled(path)} />
                    </ModelList>
                </Card>

                <Card
                    label={'Иерархия Сотрудников'}
                    title={'Иерархия сотрудников, управляющих отмеченными подразделениями'}
                    collapse>
                    <ModelList
                        collection={this.collectionToHierarchyList(this.collectionToModelList(collection, true))}
                        modelName='employee'
                        hierarchy>
                        <Hierarchy
                            toggleSelectedElem={path => this.toggleSelectedElem(path)}
                            urlExample={employeeSubCollectionURL}
                            loadSubCollection={(url, callback) => this.loadSubCollection(url, callback)}
                            insertCollection={(path, data) => this.insertCollection(path, data)}
                            toggleDisabled={path => this.toggleDisabled(path)} />
                    </ModelList>
                </Card>

                <Card
                    label={'Выбранные Сотрудники'}
                    title={'Список сотрудников из всех выбранных элементов'}
                    collapse>
                    <ModelList
                        collection={modelList}
                        modelName='employee'>
                        <Model
                            setSelectedElem={newState => this.setSelectedElem(newState)}
                            stateElement='selectedEmployees'
                            toggleSelectedElem={marker => this.toggleSelectedElem(marker)} />
                    </ModelList>
                </Card>

                <Card
                    label={'Неоформленные Сотрудники'}
                    title={'Сотрудники, которые еще не были наняты на работу'}
                    collection={!!unformedEmployeesCollection}
                    loadCollection={() => this.loadUnformedEmployeesCollection()}
                    loadable
                    collapse>
                    <ModelList
                        collection={unformedEmployeesCollection}
                        modelName='employee' >
                        <Model
                            setSelectedElem={newState => this.setSelectedElem(newState)}
                            stateElement='selectedEmployees'
                            toggleSelectedElem={model => this.toggleSelectedElem(model)} />
                    </ModelList>
                </Card>

                <Card
                    label={'Архив'}
                    title={'Уволенные сотрудники'}
                    collection={!!archive}
                    loadCollection={() => this.loadArchivedEmployees()}
                    loadable
                    collapse>
                    <ModelList
                        collection={archive}
                        modelName='employee' >
                        <Model
                            setSelectedElem={newState => this.setSelectedElem(newState)}
                            stateElement='selectedEmployees'
                            toggleSelectedElem={model => this.toggleSelectedElem(model)} />
                    </ModelList>
                </Card>

            </div>
        );

        const widget = (
            <WidgetSidebar>

                {cardList}

            </WidgetSidebar>
        );

        return (
            <div className={'row'}>

                {form}

                {widget}

            </div>
        );
    }
}

export default DepartmentCreate;
