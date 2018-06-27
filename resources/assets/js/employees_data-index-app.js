import React from 'react';
import ReactDOM from 'react-dom';
import HierarchyIndexPageTemplate from './components/HierarchyIndexPageTemplate';

ReactDOM.render(
    <HierarchyIndexPageTemplate
        subCollectionURL={'departments/{id}/sub-collection-list'}
        postURL={`${document.URL}events`}
        minWidth={'1250px'}
        thead={(
            <thead>
            <tr>
                <th>
                    Уровень
                </th>
                <th>
                    Подразделение
                </th>
                <th>
                    Сотрудник
                </th>
                <th>
                    Должность
                </th>
                <th>
                    Дата утверждения
                </th>
                <th>
                    Управляющий
                </th>
                <th>
                    Заработная плата
                </th>
                <th/>
                <th/>
            </tr>
            </thead>
        )}
        columnPropsList={[
            {
                modelProp: 'department',
                hierarchy: true,
            },
            {
                modelProp: 'department_name',
            },
            {
                modelProp: 'employee_full_name',
            },
            {
                modelProp: 'position_name',
            },
            {
                modelProp: 'created_at',
            },
            {
                modelProp: 'head_employee_full_name',
            },
            {
                modelProp: 'wage',
            },
            {
                modelProp: 'photo_url',
                img: true
            },
            {
                hidden: true,
                plus: true,
                edit: true,
            }
        ]}
        header={'Иерархия Сотрудников'}/>,
    document.getElementById('index-app'),
);
