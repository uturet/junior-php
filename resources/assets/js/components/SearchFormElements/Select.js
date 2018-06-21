import React from 'react'

class Select extends React.Component{

    constructor(props) {
        super(props);
        this.state = {

        }
    }

    render() {

        const options = this.props.options.map(option => {

            return (
                <option
                    value={option.value}
                    key={option.value}>
                    {option.label}
                </option>
            )
        });

        return (
            <div className={"col input-group"}>
                <select
                    onChange={e => this.props.onChange(e.target.value)}
                    className={'form-control'}
                    defaultValue={'null'}>
                    <option value="null">Нет</option>
                    {options}
                </select>
            </div>
        )
    }
}
export default Select
