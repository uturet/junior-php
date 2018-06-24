import React from 'react';
import ReactDOM from 'react-dom';

import IndexPageTemplate from './components/IndexPageTemplate';

ReactDOM.render(
    <IndexPageTemplate
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
            }
        ]}
        columnPropsList={[
            {
                modelProp: 'id',
            },
            {
                modelProp: 'employee_full_name',
            },
            {
                modelProp: 'recruitment_date',
            },
            {
                modelProp: 'phone',
            },
            {
                modelProp: 'email',
            },
            {
                modelProp: 'department_name',
            },
            {
                modelProp: 'position_name',
            },
            {
                modelProp: 'head_employee_full_name',
            },
            {
                modelProp: 'wage',
            },
        ]}

        searchFields={[
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
        ]}/>,
    document.getElementById('index-app'),
);
