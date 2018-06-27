import React from 'react'

import Button from './Button';

class TableData extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
        }
    }

    render() {
        const {modelProp, model, edit, plus, del, img, redirectProp} = this.props;

        if (img) {
            return (
                <td>
                    {model[modelProp] ? (
                        <img
                            style={{
                                width: 'auto',
                                height: 'auto',
                                minWidth: '37px',
                                maxHeight: '37px',
                            }}
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
                callOnActive={() => this.props.redirect(model[redirectProp], true)}
                showOnActive={(<i className={"fa fa-plus d-inline"}/>)}/>
        ) : null;

        const editBTN = edit ? (
            <Button
                isActive
                callOnActive={() => this.props.redirect(model[redirectProp], false)}
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
