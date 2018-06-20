import React from 'react';
import Button from './Button';

class Hierarchy extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            model: props.model,
            setSelectedElem: props.setSelectedElem,
            modelName: props.modelName,
            urlExample: props.urlExample,
        };
    }

    render() {
        const { modelName, urlExample, model } = this.state;
        if (!model[modelName] && !this.props.toggleSelectedElem) {
            return (
                <td className="py-2 px-0 pr-3">
                    <div className={`col-1 text-muted`}>
                        { model.path.length }
                    </div>
                </td>
            )
        }
        if (!model[modelName]) {return null}

        const url = urlExample.replace('{id}', model[modelName].id);
        const padding = this.props.toggleSelectedElem ?
            model.path.map((e, i) => {
                if (i !== (model.path.length - 1)) {
                    return (<div key={[e, i]} className={'col-1 border-right'} />);
                }
                return null;
            }) : null;


        const lvl = this.props.toggleSelectedElem ? null :
            (
                <span className={'px-3 align-middle text-muted'} style={{height: '100%'}}>
                    { model.path.length }
                </span>
            );

        const loadOrToggle = () => {
            if (model.sub_collection) {
                this.props.toggleDisabled(model.path);
            } else {
                this.props.loadSubCollection(
                    url,
                    response => this.props.insertCollection(model.path, response),
                );
            }
        };

        const select = this.props.toggleSelectedElem ? (
            <Button
                isActive={model.selected}
                callOnUnactive={() => this.props.toggleSelectedElem(model)}
                callOnActive={() => this.props.toggleSelectedElem(model)}
                showOnUnactive={(<i className="fa fa-bookmark-o"/>)}
                showOnActive={(<i className="fa fa-bookmark"/>)}/>
        ) : null;

        const department = this.props.toggleSelectedElem ? (
            <Button
                isDisabled
                showOnActive={model[modelName].label}
                showOnUnactive={model[modelName].label}/>
        ) : null;

        const HbtnGroup = (
            <div className="row">
                { padding }
                <div className="col">
                    { lvl }
                    <div className="btn-group">

                        {select}

                        {department}

                        <Button
                            isActive={model.disabled}
                            isDisabled={model.failed}
                            callOnActive={loadOrToggle}
                            callOnUnactive={() => this.props.toggleDisabled(model.path)}
                            showOnUnactive={(<i className="fa fa-minus" />)}
                            showOnActive={(<i className="fa fa-level-down" />)} />
                    </div>
                </div>
            </div>
        );

        return (
            <td className="py-2 px-0 pr-3 align-middle">
                { HbtnGroup }
            </td>
        );
    }
}
export default Hierarchy;
