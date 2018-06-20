import React from 'react';


class ModelList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
        };
    }

    render() {
        const {
            collection,
            children,
            hierarchy,
            modelName,
            isList,
            thead, } = this.props;

        if (!collection) { return (<div className="text-muted">Нет элементов</div>); }

        const modelList = Object.keys(collection).map(key => {
            const model = collection[key];
            if (!model[modelName] && !isList) { return null; }

            const Model = React.Children.map(children, child =>
                React.cloneElement(child, { model, hierarchy, modelName}));

            return (
                <tr
                    key={[model.id, model.path, model.selected, model.disabled, model.marker]}>
                    {Model}
                </tr>
            );
        });
        return (
            <table className="table table-hover">
                {thead}

                <tbody>

                    {modelList}

                </tbody>
            </table>
        );
    }
}
export default ModelList;
