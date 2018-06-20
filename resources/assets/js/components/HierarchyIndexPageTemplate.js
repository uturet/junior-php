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
        })
    }

    componentDidMount() {
        this.loadManagingDepartments()
    }

    render() {
        const { departmentSubCollectionURL, collection } = this.state;
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
                        undel={e.undel}
                        uneditable={e.uneditable}/>
                )
            }

        });

        const widgetSidebar = (
            <WidgetSidebar size={12} >

                <ModelList
                    isList
                    hierarchy
                    thead={thead}
                    modelName="department"
                    collection={this.collectionToHierarchyList(collection)} >

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
