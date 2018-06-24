import React from 'react'

class Select extends React.Component{

    constructor(props) {
        super(props);
        this.state = {
            col: props.col || props.col === undefined
        }
    }

    render() {
        let defaultValue = 'null';
        const options = this.props.options.map(option => {
            if (option.selected) {defaultValue = option.value}
            return (
                <option
                    value={option.value}
                    key={option.value}>
                    {option.label}
                </option>
            )
        });

        const defaultOption = defaultValue === 'null' ?
            (<option value="null">Нет</option>) : null;

        return (
            <div className={`${this.state.col ? 'col' : ''} input-group`}>
                <select
                    disabled={this.props.disabled}
                    onChange={e => this.props.onChange(e.target.value)}
                    className={'form-control'}
                    defaultValue={defaultValue}>
                    {defaultOption}
                    {options}
                </select>
            </div>
        )
    }
}
export default Select
