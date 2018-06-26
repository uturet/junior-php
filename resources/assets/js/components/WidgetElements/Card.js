import React from 'react';


class Card extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            collapse: props.collapse,
            label: props.label,
            title: props.title,
        };
    }

    toggleCollapse() {
        this.setState({
            collapse: !this.state.collapse,
        });
    }

    render() {
        const { collapse, label, title } = this.state;
        const { loadable, collection } = this.props;

        const loadOrToggle = () => {
            if (loadable && !collection) {
                this.props.loadCollection();
                this.toggleCollapse();
            } else {
                this.toggleCollapse();
            }
        }

        const header = (
            <span className={'d-block'} onClick={loadOrToggle} title={title}>
                {label}
            </span>
        );

        const reload = (
            <button className={'btn btn-outline-secondary icon-btn'} onClick={() => this.props.loadCollection()}>
                <i className="fa fa-refresh" />
            </button>
        )

        if (collapse) {
            return (
                <div className="card-body text-muted widget-card" style={{ cursor: 'pointer' }}>
                    {header}
                </div>
            );
        }

        return (
            <div className="card-body">
                <h4 className="card-title" style={{ cursor: 'pointer' }} title={title}>
                    {header}
                </h4>
                <div className="table-responsive">

                    { loadable ? (collection ? this.props.children : reload ) : this.props.children }

                </div>
            </div>
        );
    }
}
export default Card;
