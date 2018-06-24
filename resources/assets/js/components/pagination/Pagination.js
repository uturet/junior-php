import React from 'react'

class Pagination extends React.Component{

    constructor(props) {
        super(props);
        this.state = {
        }
    }

    getPageURL(page) {
        return `${this.props.url}page=${page}`;
    }

    getSideLinks(from, to, preLink = false, postLink = false) {

        let links = [];

        if (preLink !== false) {
            links.push(...[
                (<li key={from - 20} className={"page-item"}><span className={"page-link"}
                    onClick={() => this.props.load(this.getPageURL(preLink))}>{preLink}</span></li>),
                (<li key={from - 10} className={"page-item disabled"}>
                    <span className={"page-link"}>...</span>
                </li>)
            ])
        }

        for (let i = from; i <= to; i++) {
            links.push(
                <li key={i} className={"page-item"}><span className={"page-link"}
                    onClick={() => this.props.load(this.getPageURL(i))}>{i}</span></li>
            )
        }


        if (postLink !== false) {
            links.push(...[
                (<li key={from + 60} className={"page-item disabled"}>
                    <span className={"page-link"}>...</span>
                </li>),
                (<li key={from + 70} className={"page-item"}>
                    <span className={"page-link"}
                            onClick={() => this.props.load(this.getPageURL(postLink))}>
                        {postLink}
                    </span>
                </li>)
            ])
        }

        return links;
    }

    changeCurrentPage(page) {
        if (page < this.props.last_page) {
            this.onClick(page)
        }
    }

    render() {

        const {current_page, last_page} = this.props;

        const pageElements = 1;

        let leftArrow;
        if (current_page === 1) {
            leftArrow = (
                <li className={'page-item disabled'}>
                    <span className={"page-link"}>&laquo;</span>
                </li>
            )
        } else {
            leftArrow = (
                <li className={"page-item"}>
                    <span className={"page-link"}
                           onClick={() => this.props.load(this.getPageURL(current_page - 1))}
                           rel="prev">
                        &laquo;
                    </span>
                </li>
            );
        }

        let leftLinks = current_page - pageElements > 1 ?
            this.getSideLinks(current_page - pageElements, current_page - 1, 1):
            this.getSideLinks(1, current_page - 1);

        const currentPage = (
            <li className={"page-item disabled"}>
                <span className={"page-link"}>{current_page}</span>
            </li>
        );

        let rightLinks = last_page - current_page > pageElements ?
            this.getSideLinks(current_page + 1, current_page + pageElements, false, last_page):
            this.getSideLinks(current_page + 1, last_page);

        let rightArrow;
        if (current_page === last_page || last_page === 0) {
            rightArrow = (
                <li className={'page-item disabled'}>
                    <span className={"page-link disabled"}>&raquo;</span>
                </li>
            )
        } else {
            rightArrow = (
                <li className={"page-item"}>
                    <span className={"page-link"}
                          onClick={() => this.props.load(this.getPageURL(current_page + 1))}
                          rel="next">
                        &raquo;
                    </span>
                </li>
            );
        }

        return (
            <div>
                <div className='row'>
                    <ul className={'pagination'}>

                        {leftArrow}
                        {leftLinks}
                        {currentPage}
                        {rightLinks}
                        {rightArrow}

                    </ul>

                </div>

                <div className="row">
                    <div className="input-group">
                        <input type="number" className="form-control" value={current_page}
                               onChange={e => this.changeCurrentPage(parseInt(e.target.value))}/>
                    </div>
                </div>

            </div>
        )
    }
}
export default Pagination
