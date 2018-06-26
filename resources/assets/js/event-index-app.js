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
                value: 'description',
                label: 'Описание'
            },
            {
                hidden: true,
                del: true
            },
        ]}
        warning={'Событие будет удалено, а измененные данные сотрудника возвращены!'}
        header={'Список Событий'} />,
    document.getElementById('index-app'),
);
