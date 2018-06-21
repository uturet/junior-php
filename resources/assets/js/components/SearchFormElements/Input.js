import React from 'react'

class Input extends React.Component{

    constructor(props) {
        super(props);
        this.state = {
            value: ''
        };

    }

    handleChange(value) {
        this.setState({value});
        this.props.onChange(value);
    }

    render() {
        const {value} = this.state;
        return (
            <div className={'col input-group'}>
                <input itemType={"text"} className={`form-control${value ? '' : ' is-invalid'}`}
                       value={value}
                       onChange={e => this.handleChange(e.target.value)}/>
            </div>
        )
    }
}
export default Input