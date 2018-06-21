import React from 'react';
import ReactDOM from 'react-dom';
import SearchForm from "./components/SearchForm";

ReactDOM.render(
    <SearchForm
        options={[
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
        ]}
    />,
    document.getElementById('search-form-app')
);
