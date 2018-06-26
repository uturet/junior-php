import React from 'react'
import WidgetInterface from './WidgetInterface';


import WidgetSidebar from "./WidgetElements/WidgetSidebar";
import ModelList from "./WidgetElements/ModelList";
import TableData from "./WidgetElements/TableData";
import Pagination from "./pagination/Pagination";
import SearchForm from "./SearchForm";
import Select from "./SearchFormElements/Select";

class IndexPageTemplate extends WidgetInterface {

    constructor(props) {
        super(props);
        this.state = Object.assign(this.state, {
            collection: [],
            onLoad: true,
            CollectionListURL: props.url,
            direction: 'desc',
            searchValue: null,
        });
    }

    componentDidMount() {
        this.loadCollectionList(this.state.CollectionListURL)
    }

    redirect(id, isEdit = false) {

        if (!isEdit) {
            document.location.assign(`${document.location.pathname}/${id}/edit`);
        } else {
            document.location.assign(`/events/${id}`);
        }

    }

    selectTypeLoadCollection(url, searchValue = null) {
        this.setState({
            CollectionListURL: url,
            query: '',
            sort: '',
            searchValue
        });
        this.loadCollectionList(url);
    }

    changeDirection(dir) {
        const options = {
            'asc': 'desc',
            'desc': 'asc'
        };
        return options[dir];
    }

    sortBy(value, onLoad) {
        if (!onLoad && value !== this.state.searchValue ) {
            const {CollectionListURL, direction, sort, query} = this.state;

            const dir = value === sort ?
                this.changeDirection(direction):
                'desc';

            const newQuery = `${value}=_query&direction=${dir}`;

            const url = query ?
                CollectionListURL.replace(query, newQuery) :
                `${CollectionListURL}${newQuery}&`;

            this.setState({
                sort: value,
                query: newQuery,
                CollectionListURL: url,
                direction: dir
            });
            this.loadCollectionList(url);
        }
    }

    render() {
        const {searchValue, collection, onLoad, CollectionListURL, current_page, last_page, sort, direction} = this.state;
        const {header, searchFields, employeesType, warning} = this.props;

        const rowList = searchFields.map(e => {
            return (
                <TableData
                    key={`${e.value}`}
                    modelProp={e.value}
                    delete={e.hidden ? id => this.deleteItem(
                        id,
                        warning,
                        CollectionListURL
                    ) : undefined}
                    redirect={(id, isEdit)=> this.redirect(id, isEdit)}
                    del={e.del}
                    plus={e.plus}
                    edit={e.edit}/>
            )
        });

        const tableHeadList = searchFields.map(e => {
            if (e.hidden) {
                return (
                    <td key={'disabled'}/>
                )
            } else {
                return (
                    <td
                        className={`sort-col${onLoad || e.value === searchValue ? ' text-muted' : ''}`+
                        `${e.value === sort && direction === 'asc' ? ' dropup' : ''}`}
                        onClick={() => this.sortBy(e.value, onLoad)}
                        key={e.value}>
                    <span className={`${e.value === sort ? ' dropdown-toggle' : ''}`}>
                        {e.label}
                    </span>
                    </td>
                )
            }
        });

        const tableHead = (
            <thead>
            <tr>
                {tableHeadList}
            </tr>
            </thead>
        );

        const widgetSidebar = (
            <WidgetSidebar size={12} >

                <ModelList
                    thead={tableHead}
                    isList
                    collection={collection} >

                    {rowList}

                </ModelList>

            </WidgetSidebar>
        );

        const pagination = current_page ? (
            <div className="table-responsive card-body d-flex justify-content-center">
                <Pagination
                    disabled={onLoad}
                    url={CollectionListURL}
                    current_page={current_page}
                    last_page={last_page}
                    load={url => this.loadCollectionList(url)}/>
            </div>
        ) : null;

        const selectTypes = employeesType ? (
            <Select
                col={false}
                disabled={onLoad}
                onChange={url => this.selectTypeLoadCollection(url)}
                options={employeesType}/>
        ) : null;

        return (
            <div className='row'>
                <div className="col">
                    <div className="card">

                        <div className="card-body">
                            <h4 className="card-title">{header}</h4>
                            {selectTypes}
                        </div>

                        <div className="card-body">
                            <SearchForm
                                disabled={onLoad}
                                onSearch={(current_page, last_page) => this.setState({current_page, last_page})}
                                url={CollectionListURL}
                                load={(url, searchValue) => this.selectTypeLoadCollection(url, searchValue)}
                                options={searchFields}/>
                        </div>

                        <div className="card-body">
                            <div className='table-responsive'>
                                {widgetSidebar}
                            </div>
                        </div>

                        {pagination}

                    </div>
                </div>
            </div>
        );
    }
}

export default IndexPageTemplate;
