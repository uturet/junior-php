import React from 'react'
import Select from "./SearchFormElements/Select";
import Input from "./SearchFormElements/Input";

class SearchForm extends React.Component{

    constructor(props) {
        super(props);
        this.state = {
            inputValue: '',
            selectedValue: 'null',
            redirectURL: ''
        }
    }

    redirect() {
        const {inputValue, selectedValue} = this.state;

        let url = `${document.location.origin}${document.location.pathname}`;
        url = inputValue ? `${url}?${selectedValue}=${inputValue}` : url ;

        document.location.assign(url);
    }

    render() {

        const {options} = this.props;

        return (
            <div>
                <div className={"row form-group"}>
                    <Input
                        onChange={value => this.setState({inputValue: value})}/>

                    <Select
                        onChange={value => this.setState({selectedValue: value})}
                        options={options} />

                </div>
                <div className={"row form-group"}>
                    <div className={"col"}>
                        <button
                            className={"btn btn-primary btn-block"}
                            onClick={() => this.redirect()}
                            disabled={this.state.selectedValue === 'null' ? true : false}>
                                Поиск
                        </button>
                    </div>
                </div>
            </div>
        )
    }
}
export default SearchForm
