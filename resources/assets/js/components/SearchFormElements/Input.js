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
        const {disabled} = this.props;
        return (
            <div className={'col input-group'}>
                <input itemType={"text"} className={'form-control'}
                       disabled={disabled}
                       value={value}
                       onChange={e => this.handleChange(e.target.value)}/>
            </div>
        )
    }
}
export default Input