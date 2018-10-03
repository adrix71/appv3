<?php
/**
 * Pop Web Bootstrap Application Framework role form configuration
 */
return [
    [
        'submit' => [
            'type'       => 'submit',
            'value'      => 'Save',
            'attributes' => [
                'class'  => 'btn btn-md btn-info btn-block text-uppercase'
            ]
        ],
        'role_parent_id' => [
            'type'       => 'select',
            'label'      => 'Parent',
            'values'     => null
        ],
        'verification' => [
            'type'      => 'radio',
            'label'     => 'Verification',
            'values'    => [
                '1' => 'Yes',
                '0' => 'No'
            ],
            'checked' => 0
        ],
        'approval' => [
            'type'      => 'radio',
            'label'     => 'Approval',
            'values'     => [
                '1' => 'Yes',
                '0' => 'No'
            ],
            'checked' => 0
        ],
        'email_as_username' => [
            'type'      => 'radio',
            'label'     => 'Email as Username',
            'values'    => [
                '1' => 'Yes',
                '0' => 'No'
            ],
            'checked' => 0
        ],
        'email_required' => [
            'type'      => 'radio',
            'label'     => 'Email Required',
            'values'     => [
                '1' => 'Yes',
                '0' => 'No'
            ],
            'checked' => 0
        ],
        'id' => [
            'type'  => 'hidden',
            'value' => '0'
        ]
    ],
    [
        'name' => [
            'type'       => 'text',
            'label'      => 'Name',
            'required'   => 'true',
            'attributes' => [
                'size'   => 60,
                'style'  => 'width: 99.5%',
                'class'  => 'form-control'
            ]
        ]
    ],
    [
        'resource_1' => [
            'type'       => 'select',
            'label'      => '<a href="#" id="permission-add-link">[+]</a> Resources, Actions &amp; Permissions',
            'values'     => null
        ],
        'action_1' => [
            'type'       => 'select',
            'values'     => ['----' => '----']
        ],
        'permission_1' => [
            'type'     => 'select',
            'values'   => [
                '----' => '----',
                '0'    => 'deny',
                '1'    => 'allow'
            ]
        ]
    ]
];

