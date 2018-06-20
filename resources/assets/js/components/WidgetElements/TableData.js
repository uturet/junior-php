import React from 'react'

import Button from './Button';

class TableData extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
        }
    }

    render() {
        const {modelProp, model, uneditable, undel, img} = this.props;

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

        const del = undel ? null : (
            <Button
                isActive
                callOnActive={() => this.props.delete(model.id)}
                showOnActive={(<i className="fa fa-times"/>)}/>
        );

        const edit = uneditable ? null : (
            <Button
                isActive
                callOnActive={() => this.props.redirect(model.id)}
                showOnActive={(<i className="fa fa-pencil"/>)}/>
        );
        const optionButtons = (
            <div className="btn-group">
                {del}

                {edit}
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
