import React from 'react';

const Button = (props) => {
    const { label, isDisabled, alert } = props.validation;

    const message = alert ? (
        <div className="alert alert-warning col-12 text-center" role="alert">
            {alert}
        </div>
    ) : null;

    return (
        <div className="form-group row justify-content-around">
            {message}
            <div className="col-md-7">
                <button
                    className="btn btn-primary btn-block"
                    type="submit"
                    onClick={() => props.submitForm()}
                    disabled={isDisabled}>
                    {label}
                    </button>
            </div>
        </div>
    );
};
export default Button;
