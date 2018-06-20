import React from 'react';


class WidgetSidebar extends React.Component {

    constructor(props) {
        super(props);
        this.state = {

        };
    }

    render() {
        const {children, size} = this.props;

        return (
            <div className={`col-md-${size ? size : 6} grid-margin stretch-card`}>
                <div className="row card">
                    <div className="col-12">

                        {children}

                    </div>
                </div>
            </div>
        );
    }
}
export default WidgetSidebar;
