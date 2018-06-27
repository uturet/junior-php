import React from 'react'
import WidgetInterface from './WidgetInterface';


import WidgetSidebar from "./WidgetElements/WidgetSidebar";
import ModelList from "./WidgetElements/ModelList";
import TableData from "./WidgetElements/TableData";
import Hierarchy from "./WidgetElements/Hierarchy";

class HierarchyIndexPageTemplate extends WidgetInterface {

    constructor(props) {
        super(props);
        this.state = Object.assign(this.state, {
            collection: [],
            onLoad: true,
            departmentSubCollectionURL: props.subCollectionURL,
            success: '#58d8a3',
            danger: '#d85858',
        })
    }

    componentDidMount() {
        this.loadManagingDepartments()
    }

    loadSubCollectionByDrag(stateName, upLvl = 'dragged') {

        let path;
        if (this.state[stateName].length > 1) {
            path = stateName === upLvl ? this.state.dragged.slice(0, this.state.dragged.length - 1) :
                this.state.enter;
        } else {
            path = this.state[stateName];
        }

        const model = this.getSubCollection(
            path,
            this.state.collection,
            true
        );

        this.loadSubCollection(
            this.state.departmentSubCollectionURL.replace('{id}', model.department.id),
            response => this.insertCollection(
                path,
                response,
                true
            )
        );

    }

    changeCollection() {

        const minPathLen = this.state.enter.length <= this.state.dragged.length ? 'enter' : 'dragged';
        const maxPathLen = minPathLen === 'dragged' ? 'enter' : 'dragged';

        let isEqual = true;

        const array = this.state[minPathLen];

        Array.from(array).forEach((e, i) => {
            if (e !== this.state[maxPathLen][i]) {
                isEqual = false
            }
        });

        console.log(isEqual);

        if (isEqual) {
            this.loadSubCollectionByDrag(minPathLen, minPathLen);
        } else {
            this.loadSubCollectionByDrag(minPathLen);
            this.loadSubCollectionByDrag(maxPathLen);
        }
    }

    onDragStart(path) {
        this.setState({dragged: path})
    }

    onDragEnd(path) {
        const {dragged, enter, collection} = this.state;

        if (path.toString() !== enter.slice(0, path.length).toString() && path.length > 1) {

            const enterModel = this.getSubCollection(
                enter,
                collection,
                true
            );

            if (enterModel.department) {
                const draggedModel = this.getSubCollection(
                    dragged,
                    collection,
                    true
                );

                const formData = {
                    _token: window.csrf,
                    department_id: enterModel.department.id,
                    employee_id: draggedModel.employee_id,
                    description: `Перевод сотрудника '${draggedModel.employee_full_name}' из подразделения ` +
                        `'${draggedModel.department_name}' ` +
                        ` в подразделение '${enterModel.department.label}'`
                };

                this.submitForm(
                    formData,
                    this.props.postURL,
                    false,
                    () => this.changeCollection()
                )
            } else {
                alert('Должно быть установлено управляемое подразделение ' +
                    '(Подразделение > создать/редактировать)')
            }

        } else {
            alert('Действие невозможно!')
        }

        this.setState({enterColor: null})
    }

    onDragEnter(path) {
        const {dragged, danger} = this.state;
        let enterColor = danger;

        if (dragged.toString() !== path.slice(0, dragged.length).toString()) {
            enterColor = this.state.success
        }

        this.setState({
            enter: path,
            enterColor
        });
    }

    redirect(id, isEdit = false) {

        if (!isEdit) {
            document.location.assign(`employees/${id}/edit`);
        } else {
            document.location.assign(`/events/${id}`);
        }

    }

    render() {
        const { departmentSubCollectionURL, collection, enterColor, enter, dragged} = this.state;
        const {header, thead, columnPropsList} = this.props;

        const rowList = columnPropsList.map((e, i) => {
            if (e.hierarchy) {
                return (
                    <Hierarchy
                        modelName={'department'}
                        key={`${e.modelProp}${i}`}
                        urlExample={departmentSubCollectionURL}
                        loadSubCollection={(url, callback) => this.loadSubCollection(url, callback)}
                        insertCollection={(path, data) => this.insertCollection(path, data)}
                        toggleDisabled={path => this.toggleDisabled(path)} />
                )
            } else {
                return (
                    <TableData
                        key={`${e.modelProp}${i}`}
                        img={e.img}
                        modelProp={e.modelProp}
                        del={e.del}
                        plus={e.plus}
                        edit={e.edit}
                        redirect={(id, isEdit)=> this.redirect(id, isEdit)}
                        redirectProp={'employee_id'} />
                )
            }

        });

        const widgetSidebar = (
            <WidgetSidebar size={12} >

                <ModelList
                    draggable
                    enterColor={enterColor}
                    enter={enter}
                    dragged={dragged}
                    isList
                    hierarchy
                    thead={thead}
                    modelName="department"
                    collection={this.collectionToHierarchyList(collection)}
                    onDragStart={path => this.onDragStart(path)}
                    onDragEnd={path => this.onDragEnd(path)}
                    onDragEnter={path => this.onDragEnter(path)} >

                    {rowList}

                </ModelList>

            </WidgetSidebar>
        );

        return (
            <div className={'row'}>
                <div className="col">
                    <div className="card">
                        <div className="card-body">
                            <h4 className="card-title">
                                {header}
                            </h4>
                            <div className={'table-responsive'}>
                                <div style={{minWidth: this.props.minWidth}}>
                                    {widgetSidebar}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default HierarchyIndexPageTemplate;
