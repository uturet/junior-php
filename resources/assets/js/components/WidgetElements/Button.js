import React from 'react';


class Button extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            name: props.name,
            isActive: !!props.isActive,
            isDisabled: !!props.isDisabled,
            callOnActive: props.callOnActive,
            callOnUnactive: props.callOnUnactive,
            showOnActive: props.showOnActive,
            showOnUnactive: props.showOnUnactive,
        };
    }

    toggleActive() {
        const { isActive, callOnActive, callOnUnactive } = this.props;

        if (isActive && callOnActive) {
            callOnActive();
        } else {
            callOnUnactive();
        }
    }

    render() {
        const { isActive, showOnActive, showOnUnactive, isDisabled } = this.props;


        if (isDisabled) {
            return (
                <span
                    className="btn btn-outline-secondary icon-btn disabled">
                    { isActive ? showOnActive : showOnUnactive }
                </span>
            );
        }
        return (
            <button
                type="button"
                className="btn btn-outline-secondary icon-btn"
                onClick={() => this.toggleActive()}>
                { isActive ? showOnActive : showOnUnactive }
            </button>
        );
    }
}
export default Button;
