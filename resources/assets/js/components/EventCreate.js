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


class EventCreate extends WidgetInterface {

    constructor(props) {
        super(props);
        this.state = Object.assign(this.state, {
            employeeMarker: window.selectedEmployee ? window.selectedEmployee.marker : 'null',
            employee: window.selectedEmployee ? window.selectedEmployee.id : 'null',
            managinDepartmentsURL: 'managing-departments/widget',
            department: 'null',
            headEmployee: 'null',
            position: 'null',
            wage: '',
            description: '',
            exceptionModelID: undefined,
            dataItems: {
                employee: 'employee_id',
                department: 'department_id',
                headEmployee: 'head_employee_id',
                position: 'position_id',
                wage: 'wage',
                description: 'description'
            },
        });

    }

    componentDidMount() {
        this.loadManagingDepartments()
    }

    downState() {
        this.setState({
            employeeMarker: 'null',
            employee: 'null',
            department: 'null',
            headEmployee: 'null',
            position: 'null',
            wage: '',
            description: '',
            exceptionModelID: '',
            collection: null,
            archive: null,
            freePositions: null,
            unformedEmployeesCollection: null,
            down: true
        });

        this.loadManagingDepartments();
    }

    getValidation() {
        const {employee, department, position, wage, description, employeeMarker} = this.state;
        const andElse = (department !== 'null' && position !== 'null' && wage);
        const orElse = (department !== 'null' || position !== 'null' || wage);

        let validate = ['employee', 'button'];
        let is_archive = 0;

        if (employeeMarker === 'collection') {
            validate = ['employee', 'description', 'button'];
        } else if (employeeMarker !== 'null') {
            validate = ['employee', 'department', 'position', 'headEmployee', 'wage', 'description', 'button'];
        }

        const validation = {};
        validate.forEach((e) => {
            validation[e] = (this.state[e] === 'null') || !this.state[e] ? 'is-invalid' : '';
        });

        validation.button = { isDisabled: true, label: 'Создать Событие' };

        if (employee !== 'null' && description) {
            if (employeeMarker !== 'collection' && andElse) {
                validation.button = { isDisable: false, label: 'Нанять Сотрудника' };
            } else if (employeeMarker === 'collection' && orElse) {
                validation.button = { isDisable: false, label: 'Перевести Сотрудника' };
            } else if (employeeMarker === 'collection') {
                validation.button = { isDisable: false, label: 'Уволить Сотрудника' };
                is_archive = 1;
            }
        }

        return [validation, is_archive];
    }

    render() {
        const {
            down,
            collection,
            archive,
            unformedEmployeesCollection,
            freePositions,
            departmentSubCollectionURL,
            employeeSubCollectionURL,
            exceptionModelID,
            employee,
            department,
            position,
            wage,
            description,
            dataItems,
            headEmployee } = this.state;

        const [validation, is_archive] = this.getValidation();
        const formData = {_token: window.csrf, is_archive: is_archive};
        const state = this.state;
        const mainCollection = [];

        Object.keys(dataItems).forEach(key => {
            if (state[key] && state[key] !== 'null') {
                formData[dataItems[key]] = state[key];
            }
        });

        if (collection) { mainCollection.push(...collection); }
        if (unformedEmployeesCollection) { mainCollection.push(...unformedEmployeesCollection); }
        if (archive) { mainCollection.push(...archive); }
        if (freePositions) { mainCollection.push(...freePositions); }
        const modelList = this.collectionToModelList(mainCollection, false);

        const isEdit = !!window.selectedEmployee;

        const form = (
            <CreationForm
                validation={validation}
                modelList={modelList} >

                <Select
                    stateName={'employee'}
                    label={'Сотрудник'}
                    name={'employee_id'}
                    modelName={'employee'}
                    modelList={modelList}
                    value={employee}
                    setMarker={marker => this.setEmployeeMarker(marker)}
                    setValue={value => this.setEmployee(value)}
                    exceptionModelID={exceptionModelID}
                    defaultValue={window.selectedEmployee && !down ? window.selectedEmployee: null} />

                <Select
                    stateName={'department'}
                    label={'Подразделение'}
                    name={'department_id'}
                    modelName={'department'}
                    modelList={modelList}
                    value={department}
                    setValue={value => this.setDepartment(value)}
                    chainedModelName={'employee'}
                    downChainedValue={model => this.downSelected('null', model)}
                    setChainedValue={value => this.setHeadEmployee(value)}
                    setExceptionModelID={id => this.setExceptionModelID(id)} />

                <Select
                    stateName={'headEmployee'}
                    label={'Управляющий'}
                    name={'head_employee_id'}
                    modelName={'employee'}
                    modelList={modelList}
                    value={headEmployee}
                    setValue={value => this.setHeadEmployee(value)}
                    chainedModelName={'department'}
                    downChainedValue={model => this.downSelected('null', model)}
                    setChainedValue={value => this.setDepartment(value)}
                    setExceptionModelID={id => this.setExceptionModelID(id)} />

                <Select
                    stateName={'position'}
                    label={'Должность'}
                    name={'position_id'}
                    modelList={modelList}
                    value={position}
                    setValue={value => this.setPosition(value)}
                    modelName={'position'} />

                <Input
                    stateName={'wage'}
                    label={'Оплата Труда'}
                    name={'wage'}
                    value={wage}
                    setValue={value => this.setWage(value)}
                    type={'number'} />

                <Input
                    stateName={'description'}
                    label={'Описание'}
                    name={'description'}
                    value={description}
                    setValue={value => this.setDescription(value)}
                    type={'text'} />

                <Button
                    submitForm={() => this.submitForm(
                        formData,
                        document.URL.replace(isEdit ? /\/[0-9].*/ : '/create', ''),
                        false,
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
                            toggleSelectedElem={model => this.toggleSelectedElem(model)}
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
                        modelName='employee' >
                        <Model
                            toggleSelectedElem={model => this.toggleSelectedElem(model)} />
                    </ModelList>
                </Card>

                <Card
                    label={'Выбранные Должности'}
                    title={'Список должностей из всех выбранных элементов'}
                    collapse>
                    <ModelList
                        collection={modelList}
                        modelName='position' >
                        <Model
                            toggleSelectedElem={model => this.toggleSelectedElem(model)} />
                    </ModelList>
                </Card>

                <Card
                    label={'Свободные должности'}
                    title={'Должности на которые еще не были приняты сотрудники'}
                    collection={!!freePositions}
                    loadCollection={() => this.loadFreePositionsCollection()}
                    loadable
                    collapse>
                    <ModelList
                        collection={freePositions}
                        modelName='position' >
                        <Model
                            toggleSelectedElem={model => this.toggleSelectedElem(model)} />
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
export default EventCreate;
