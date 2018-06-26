import React from 'react';

const Input = (props) => {
    const { label, name, type, validation, value } = props;

    return (
        <div className="form-group row py-3">
            <label className="col-3 col-form-label" htmlFor={name}>{label}</label>
            <div className="col input-group">
                <input
                    type={type}
                    className={`form-control ${validation ? validation : ''}`}
                    id={name}
                    name={name}
                    value={value}
                    onChange={e => props.setValue(e.target.value)} />
            </div>
        </div>
    );
}

export default Input;
