import React from 'react';
import Button from './Button';

class Model extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            model: props.model,
            setSelectedElem: props.setSelectedElem,
            modelName: props.modelName,
            urlExample: props.urlExample,
            loadSub: props.loadSubCollection,
        };
    }

    render() {
        const { modelName, model } = this.state;
        if (!model[modelName]) {return null}

        const LbtnGroup = (
            <div className="row">
                <div className="col">
                    <div className="btn-group" role="group" aria-label="Basic example">
                        <Button
                            isActive={!model.selected}
                            callOnActive={() => this.props.toggleSelectedElem(model)}
                            callOnUnactive={() => this.props.toggleSelectedElem(model)}
                            showOnActive={(<i className="fa fa-bookmark-o" />)}
                            showOnUnactive={(<i className="fa fa-bookmark" />)} />
                        <Button
                            isDisabled
                            showOnActive={model[modelName].label}
                            showOnUnactive={model[modelName].label} />
                    </div>
                </div>
            </div>
        );

        return (
            <td className="py-2 px-0 pr-3">
                { LbtnGroup }
            </td>
        );
    }
}
export default Model;
