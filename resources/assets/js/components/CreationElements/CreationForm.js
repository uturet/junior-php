import React from 'react';

class CreationForm extends React.Component {

    constructor(props) {
        super(props);
        this.state = {

        };
    }

    render() {
        const { validation, children, size } = this.props;
        const selectList = validation ? React.Children.map(children, child => React.cloneElement(child, {
            validation: validation[child.props.stateName],
        })) : children;


        return (
            <div className={`col-md-${size ? size : 6} grid-margin stretch-card`}>
                <div className={'card'}>
                    <div className={'card-body'}>
                        <div className={'row'}>
                            <div className="col-sm-12">
                                {selectList}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
export default CreationForm;