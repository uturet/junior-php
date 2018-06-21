import React from 'react';
import axios from 'axios/index';


class WidgetInterface extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            managinDepartmentsURL: 'managing-departments',
        };
    }

    loadManagingDepartments() {
        this.loadSubCollection(
            this.state.managinDepartmentsURL,
            (response) => {
                this.addPath(response.data, [], 'collection');
                this.setState({ collection: response.data });
            },
        );
    }

    downSelected(nullValue, model) {

        if (model.employee) {
            if (model.employee.id === this.state.employee) {
                this.setState({
                    employee: nullValue,
                    employeeMarker: nullValue,
                });
            } else if (model.employee.id === this.state.headEmployee) {
                this.setState({
                    exceptionModelID: null,
                    headEmployee: nullValue,
                    department: nullValue,
                });
            }
        } else if (model.department) {
            if (model.department.id === this.state.department) {
                this.setState({
                    exceptionModelID: null,
                    headEmployee: nullValue,
                    department: nullValue,
                });
            }
        }
        if (model.position) {
            if (model.position.id === this.state.position) {
                this.setState({
                    position: nullValue,
                });
            }
        }
    }

    addPath(data, path = [], marker) {
        Array.from(data).forEach((e, i) => {
            e.path = path.slice();
            e.path.push(i);
            e.disabled = true;
            e.marker = marker;
        });
    }

    getSubCollection(path, mainCollection = this.state.collection, justSub = false) {

        const collection = JSON.parse(JSON.stringify(mainCollection));

        let coll = collection;
        path.forEach((e, i) => {
            if (coll[e].sub_collection && (path.length - 1) !== i) {
                coll = coll[e].sub_collection;
            } else {
                coll = coll[e];
            }
        });

        if (justSub) {
            return coll;
        }

        return [collection, coll];
    }

    insertCollection(path, response, disabledSetFalse = false) {
        const [collection, coll] = this.getSubCollection(path);

        if (response.data.length) {
            this.addPath(response.data, path, 'collection');
            coll.sub_collection = response.data;
        } else {
            coll.failed = true;
            coll.sub_collection = undefined;
            disabledSetFalse = false
        }
        this.setState({ collection });
        this.toggleDisabled(path, disabledSetFalse)
    }

    loadSubCollection(baseUrl, callback, reload = true, urlBuilder = true) {
        axios.create({
            baseURL: urlBuilder ? `${document.location.origin}/api/${baseUrl}` : baseUrl,
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .get()
        .then(response => {
            if (response.status === 500 && reload) {
                this.loadSubCollection(baseUrl, callback, false)
            } else {
                callback(response)
            }

        });
    }

    redirect() {
        document.location.assign(document.URL.replace(/\/[0-9].*/, ''));
    }

    toggleDisabled(path, setFalse = false) {
        const [collection, coll] = this.getSubCollection(path);

        if (setFalse) {
            coll.failed = false;
            coll.disabled = false;
        } else {
            coll.disabled = !coll.disabled;
        }

        this.setState({ collection });
    }

    toggleSelectedElem(model) {
        let mainCollection;

        if (model.marker === 'collection') {
            mainCollection = this.state.collection;
        } else if (model.marker === 'unformed') {
            mainCollection = this.state.unformedEmployeesCollection;
        } else if (model.marker === 'archive') {
            mainCollection = this.state.archive;
        } else if (model.marker === 'positions') {
            mainCollection = this.state.freePositions;
        }

        const [collection, coll] = this.getSubCollection(model.path, mainCollection);

        if (coll.selected) {
            coll.selected = false;
        } else {
            coll.selected = true;
        }

        if (model.marker === 'collection') {
            this.setState({ collection });
        } else if (model.marker === 'unformed') {
            this.setState({ unformedEmployeesCollection: collection });
        } else if (model.marker === 'archive') {
            this.setState({ archive: collection });
        } else if (model.marker === 'positions') {
            this.setState({ freePositions: collection });
        }

        this.downSelected('null', model);
    }

    collectionToHierarchyList(collection) {
        let modelList = {};
        if (!collection) { return null; }

        Object.keys(collection).forEach(((key) => {
            const e = collection[key];
            modelList[Math.random().toString()] = e;
            if (e.sub_collection && !e.disabled) {
                modelList = Object.assign(
                    modelList,
                    this.collectionToHierarchyList(e.sub_collection));
            }
        }));
        return modelList;
    }

    collectionToModelList(collection, surfaceSelection) {
        let modelList = {};
        if (!collection) { return null; }
        if (surfaceSelection) {
            collection.forEach(((e) => {
                if (e.selected) {
                    modelList[Math.random().toString()] = e;
                } else if (e.sub_collection) {
                    modelList = Object.assign(
                        modelList,
                        this.collectionToModelList(e.sub_collection, surfaceSelection));
                }
            }));
        } else {
            collection.forEach(((e) => {
                if (e.selected) {
                    modelList[Math.random().toString()] = e;
                }
                if (e.sub_collection) {
                    modelList = Object.assign(
                        modelList,
                        this.collectionToModelList(e.sub_collection, surfaceSelection));
                }
            }));
        }

        return modelList;
    }


    loadCollectionList(url) {
        this.setState({onLoad: true});

        if (url) {
            this.loadSubCollection(
                url,
                (response) => this.setState(oldState => {
                    oldState.collection.push(...response.data.data)
                    return {
                        CollectionListURL: response.data.next_page_url,
                        collection: oldState.collection,
                        onLoad: false
                    }
                }),
                true,
                false
            )
        }

    }

}
export default WidgetInterface;
