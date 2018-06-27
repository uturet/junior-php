import React from 'react';
import ReactDOM from 'react-dom';

import IndexPageTemplate from './components/IndexPageTemplate';

ReactDOM.render(
    <IndexPageTemplate
        warning={'Вся информация о сотруднике будет удалена!'}
        header={'Информация о сотрудниках'}
        url={`${document.location.origin}/api/employees/collection-list?`}
        employeesType={[
            {
                label: 'Оформленные сотрудники',
                value: `${document.location.origin}/api/employees/collection-list?`,
                selected: true
            },
            {
                label: 'Неоформленные сотрудники',
                value: `${document.location.origin}/api/unformed-employees/collection-list?`
            },
            {
                label: 'Уволенные сотрудники',
                value: `${document.location.origin}/api/archived-employees/collection-list?`
            }
        ]}
        searchFields={[
            {
              img: true,
              value: 'photo_url'
            },
            {
                value: 'id',
                label: 'ID'
            },
            {
                value: 'employee_full_name',
                label: 'ФИО'
            },
            {
                value: 'recruitment_date',
                label: 'Дата оформления'
            },
            {
                value: 'phone',
                label: 'Телефон'
            },
            {
                value: 'email',
                label: 'Email'
            },
            {
                value: 'department_name',
                label: 'Подразделение'
            },
            {
                value: 'position_name',
                label: 'Должность'
            },
            {
                value: 'head_employee_full_name',
                label: 'Руководитель'
            },
            {
                value: 'wage',
                label: 'Заработная плата'
            },
            {
                hidden: true,
                del: true,
                plus: true,
                edit: true
            }
        ]}/>,
    document.getElementById('index-app'),
);
