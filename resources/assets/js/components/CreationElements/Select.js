import React from 'react';

class Select extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            label: props.label,
            name: props.name,
            modelList: props.modelList,
            modelName: props.modelName,
        };
    }

    handleChange(element) {
        const option = element.options[element.options.selectedIndex];
        const name = this.props.chainedModelName;
        const model = this.props.modelList[option.id];

        if (this.props.setChainedValue && this.props.downChainedValue) {
            if (option.id === 'null') {
                this.props.setChainedValue('null');
                this.props.setExceptionModelID(null);
            } else {
                if (model[name]) {
                    this.props.setChainedValue(model[name].id);
                } else {
                    this.props.setChainedValue('true');
                }
                this.props.downChainedValue(model);
                this.props.setExceptionModelID(option.id);
            }
        }

        if (this.props.setMarker) {
            if (option.id === 'null') {
                this.props.setMarker('null');
            } else if (option.id === 'edit') {
                this.props.setMarker(option.id);
            } else {
                this.props.setMarker(model.marker);
            }
        }

        this.props.setValue(option.value);
    }

    render() {
        const { name, label, value, modelList, modelName, exceptionModelID, validation, defaultValue } = this.props;
        const options = [];

        if (modelList) {
            options.push(...Object.keys(modelList).map((key) => {
                const model = modelList[key];
                if (key === exceptionModelID || !model[modelName]) { return null; }

                return (<option
                    key={model[modelName].id}
                    id={key}
                    value={model[modelName].id} >
                    {model[modelName].label}
                </option>);
            }));
        }

        return (
            <div className="form-group row py-3">
                <label className="col-3 col-form-label" htmlFor={name}>{label}</label>
                <div className="col input-group">
                    <select
                        className={`form-control ${validation ? validation : ''}`}
                        id={name}
                        value={value}
                        name={name}
                        onChange={e => this.handleChange(e.target)}>

                        <option id={defaultValue ? 'edit' : 'null'} value={defaultValue ? defaultValue.id : 'null'} >
                            {defaultValue ? defaultValue.label : 'Нет'}
                        </option>
                        {options}
                    </select>
                </div>
            </div>
        );
    }
}
export default Select;
