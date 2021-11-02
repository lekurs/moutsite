<?php

return [
    'roles' => [
        [
            'name' => 'Défaut',
            'slug' => 'default',
            'description' => 'Rôle par défaut',
            'permissions' => ['profile.update', 'email.update']
        ],
        [
            'name' => 'Admin',
            'slug' => 'administrator',
            'description' => 'Rôle administrateur',
            'permissions' => [
                'admin.modules.index',
                'user.show',
                'user.update',
                'roles.index',
                'devis.index',
                'recipes.index',
                'recipes.show',
                'recipes.update',
                'recipes.store',
                'recipes.destroy',
                'clients.index',
                'clients.show',
                'clients.update',
                'clients.store',
                'clients.destroy',
            ]
        ],
        [
            'name' => 'Recipe',
            'slug' => 'guest-recipe',
            'description' => 'Rôle invité pour les recettes',
            'permissions' => [
                'recipes.public.index',
                'recipes.public.show',
            ],
        ]
    ],
    'modules' => [
        'Administration', 'Client', 'Recettes', 'Role', 'Comptabilité',
    ],
    'permissions' => [
        [
            'key' => 'admin.modules.index',
            'name' => 'Afficher les modules',
            'description' => 'Permet d\'afficher les modules',
            'module' => '',
        ],
        [
            'key' => 'user.show',
            'name' => 'Afficher un utilisateur',
            'description' => "Permet d'afficher un utlisateur",
            'module' => '',
        ],
        [
            'key' => 'user.update',
            'name' => 'Mettre a jour un utilisateur',
            'description' => "Permet de mettre à jour un utilisateur",
            'module' => '',
        ],
        [
            'key' => 'roles.index',
            'name' => 'Voir tous les rôles d\'utilisateur',
            'description' => 'Permet de voir tous les rôles d\'utilisateur',
            'module' => '',
        ],
        [
            'key' => 'clients.index',
            'name' => 'Voir tous les clients',
            'description' => 'Donne accès au module clients',
            'module' => '',
        ],
        [
            'key' => 'clients.show',
            'name' => 'Voir un client',
            'description' => 'Permet de voir un client',
            'module' => '',
        ],
        [
            'key' => 'clients.update',
            'name' => 'Mettre à jour un client',
            'description' => 'Permet de mettre à jour un client',
            'module' => '',
        ],
        [
            'key' => 'clients.destroy',
            'name' => 'Supprimer un client',
            'description' => 'Permet de supprimer un client'
        ],
        [
            'key' => 'devis.index',
            'name' => 'Accès aux devis',
            'description' => "Donne l'accès au module des devis"
        ],
        [
            'key' => 'recipes.index',
            'name' => 'Accès aux recettes clients',
            'description' => "Donne l'accès au module des recettes"
        ],
        [
            'key' => 'recipes.show',
            'name' => 'Accès à une recette clients',
            'description' => "Donne l'accès à une recette à effectuer"
        ],
        [
            'key' => 'recipes.update',
            'name' => 'Mise à jour d\'une recette client',
            'description' => "Donne l'accès à la mise à jour d'une recette"
        ],
        [
            'key' => 'recipes.destroy',
            'name' => 'Suppression d\'une recette client',
            'description' => "Donne l'accès à la suppression d'une recette"
        ],
        [
            'key' => 'recipes.public.index',
            'name' => 'Accès aux recettes du client',
            'description' => "Donne l'accès aux recettes du client"
        ],
        [
            'key' => 'recipes.public.show',
            'name' => 'Accès à la recette du client',
            'description' => "Donne l'accès à une recette du client"
        ]
    ],
];
