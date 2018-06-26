import React from 'react';
import ReactDOM from 'react-dom';
import IndexPageTemplate from './components/IndexPageTemplate';

ReactDOM.render(
    <IndexPageTemplate
        url={`${document.location.origin}/api${document.location.pathname}/collection-list?`}
        searchFields={[
            {
                value: 'id',
                label: 'ID'
            },
            {
                value: 'name',
                label: 'Название'
            },
            {
                value: 'description',
                label: 'Описание'
            },
            {
                hidden: true,
                del: true,
                edit: true
            },
        ]}
        warning={'Подразделение будет удалено!'}
        header={'Список Подразделений'}/>,
    document.getElementById('index-app'),
);
