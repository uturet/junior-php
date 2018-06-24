import React from 'react'
import Select from "./SearchFormElements/Select";
import Input from "./SearchFormElements/Input";

class SearchForm extends React.Component{

    constructor(props) {
        super(props);
        this.state = {
            inputValue: '',
            selectedValue: 'null',
        }
    }

    load() {
        const {inputValue, selectedValue} = this.state;
        const {url} = this.props;
        const newSearchQuery = `${selectedValue}=${inputValue}&`;

        this.props.load(
            inputValue ? url.replace(/[?].*/, `?${newSearchQuery}`) : url.replace(/[?].*/, '?'),
            inputValue ? selectedValue : null
        );
    }

    render() {

        const {options, disabled} = this.props;

        return (
            <div>
                <div className={"row form-group"}>
                    <Input
                        disabled={disabled}
                        onChange={value => this.setState({inputValue: value})}/>

                    <Select
                        disabled={disabled}
                        onChange={value => this.setState({selectedValue: value})}
                        options={options} />

                </div>
                <div className={"row form-group"}>
                    <div className={"col"}>
                        <button
                            className={"btn btn-primary btn-block"}
                            onClick={() => this.load()}>
                                Поиск
                        </button>
                    </div>
                </div>
            </div>
        )
    }
}
export default SearchForm
