<?php
/**
 * Pop Web Bootstrap Application Framework profile form configuration
 */
return [
    [
        'email' => [
            'type'     => 'email',
            'label'    => 'Email',
            'required' => true,
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'password1' => [
            'type'       => 'password',
            'label'      => 'Change Password?',
            'attributes' => [
                'class' => 'form-control'
            ]
        ],
        'password2' => [
            'type'      => 'password',
            'label'     => 'Re-Type Password',
            'attributes' => [
                'class' => 'form-control'
            ]
        ]
    ],
    [
        'submit' => [
            'type'  => 'submit',
            'value' => 'Save',
            'attributes' => [
                'class'  => 'btn btn-lg btn-info btn-block text-uppercase'
            ]
        ],
        'role_id' => [
            'type'  => 'hidden',
            'value' => '0'
        ],
        'id' => [
            'type'  => 'hidden',
            'value' => '0'
        ]
    ]
];
