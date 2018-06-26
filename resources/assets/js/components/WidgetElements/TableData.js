import React from 'react'

import Button from './Button';

class TableData extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
        }
    }

    render() {
        const {modelProp, model, edit, plus, del, img} = this.props;

        if (img) {
            return (
                <td>
                    {model[modelProp] ? (
                        <img
                            className={'img-xs rounded-circle'}
                            src={`/uploads/avatars/${model[modelProp]}`}
                            alt="Фотография"/>
                    ) : null}

                </td>
            )
        }

        const delBTN = del ? (
            <Button
                isActive
                callOnActive={() => this.props.delete(model.id)}
                showOnActive={(<i className="fa fa-times"/>)}/>
        ) : null;

        const plusBTN = plus ? (
            <Button
                isActive
                callOnActive={() => this.props.redirect(model.id, true)}
                showOnActive={(<i className={"fa fa-plus d-inline"}/>)}/>
        ) : null;

        const editBTN = edit ? (
            <Button
                isActive
                callOnActive={() => this.props.redirect(model.id, false)}
                showOnActive={(<i className="fa fa-pencil"/>)}/>
        ) : null;
        const optionButtons = (
            <div className="btn-group">
                {delBTN}

                {plusBTN}

                {editBTN}
            </div>
        );

        return (
            <td>
                {modelProp ? model[modelProp] : optionButtons }
            </td>
        )
    }
}
export default TableData
