#!/bin/bash

# Script to batch update admin templates to use admin_base.html.twig

# Admin Categorie Album
cat > templates/admin_categorie_album/index.html.twig << 'EOF'
{% extends 'admin_base.html.twig' %}
{% block title %}Gestion des Catégories d'Albums{% endblock %}
{% block page_title %}Catégories d'Albums{% endblock %}
{% block body %}
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Liste des Catégories d'Albums</h2>
        <a href="{{ path('app_admin_categorie_album_new') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nouvelle Catégorie
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Nom</th><th>Actions</th></tr>
            </thead>
            <tbody>
            {% for categorieAlbum in categorie_albums %}
                <tr>
                    <td style="font-weight: 500;">{{ categorieAlbum.nomCategorie }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ path('app_admin_categorie_album_show', {'idCategorieAlbum': categorieAlbum.idCategorieAlbum}) }}" class="btn btn-sm btn-info"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ path('app_admin_categorie_album_edit', {'idCategorieAlbum': categorieAlbum.idCategorieAlbum}) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></a>
                        </div>
                    </td>
                </tr>
            {% else %}
                <tr>
                    <td colspan="2" style="text-align: center; padding: 2rem;">
                        <div style="color: var(--text-muted); margin-bottom: 1rem;">
                            <i class="fa-solid fa-folder-open" style="font-size: 2rem;"></i>
                            <p style="margin-top: 0.5rem;">Aucune catégorie trouvée</p>
                        </div>
                        <a href="{{ path('app_admin_categorie_album_new') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Créer une catégorie</a>
                    </td>
                </tr>
            {% endfor %}
            </tbody>
        </table>
    </div>
</div>
{% endblock %}
EOF

cat > templates/admin_categorie_album/new.html.twig << 'EOF'
{% extends 'admin_base.html.twig' %}
{% block title %}Nouvelle Catégorie{% endblock %}
{% block page_title %}Nouvelle Catégorie{% endblock %}
{% block breadcrumb %}<span>Administration</span> / <a href="{{ path('app_admin_categorie_album_index') }}">Catégories</a> / <span>Nouvelle</span>{% endblock %}
{% block body %}
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Ajouter une catégorie</h2>
        <a href="{{ path('app_admin_categorie_album_index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Retour</a>
    </div>
    {{ include('admin_categorie_album/_form.html.twig') }}
</div>
{% endblock %}
EOF

cat > templates/admin_categorie_album/edit.html.twig << 'EOF'
{% extends 'admin_base.html.twig' %}
{% block title %}Modifier la Catégorie{% endblock %}
{% block page_title %}Modifier la Catégorie{% endblock %}
{% block breadcrumb %}<span>Administration</span> / <a href="{{ path('app_admin_categorie_album_index') }}">Catégories</a> / <span>Modifier</span>{% endblock %}
{% block body %}
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Modifier {{ categorieAlbum.nomCategorie }}</h2>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ path('app_admin_categorie_album_index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Retour</a>
            {{ include('admin_categorie_album/_delete_form.html.twig') }}
        </div>
    </div>
    {{ include('admin_categorie_album/_form.html.twig', {'button_label': 'Mettre à jour'}) }}
</div>
{% endblock %}
EOF

cat > templates/admin_categorie_album/show.html.twig << 'EOF'
{% extends 'admin_base.html.twig' %}
{% block title %}Détails de la Catégorie{% endblock %}
{% block page_title %}Détails de la Catégorie{% endblock %}
{% block breadcrumb %}<span>Administration</span> / <a href="{{ path('app_admin_categorie_album_index') }}">Catégories</a> / <span>Détails</span>{% endblock %}
{% block body %}
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">{{ categorieAlbum.nomCategorie }}</h2>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ path('app_admin_categorie_album_index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Retour</a>
            <a href="{{ path('app_admin_categorie_album_edit', {'idCategorieAlbum': categorieAlbum.idCategorieAlbum}) }}" class="btn btn-warning"><i class="fa-solid fa-pen"></i> Modifier</a>
            {{ include('admin_categorie_album/_delete_form.html.twig') }}
        </div>
    </div>
    <table class="table">
        <tbody>
            <tr><th style="width: 30%;">Id</th><td>{{ categorieAlbum.idCategorieAlbum }}</td></tr>
            <tr><th>Nom</th><td>{{ categorieAlbum.nomCategorie }}</td></tr>
        </tbody>
    </table>
</div>
{% endblock %}
EOF

cat > templates/admin_categorie_album/_form.html.twig << 'EOF'
{% form_theme form 'bootstrap_5_layout.html.twig' %}
{{ form_start(form) }}
<div class="row"><div class="col-md-8">{{ form_widget(form) }}</div></div>
<div class="mt-4"><button class="btn btn-primary"><i class="fa-solid fa-save"></i> {{ button_label|default('Enregistrer') }}</button></div>
{{ form_end(form) }}
EOF

echo "Admin Categorie Album templates updated!"
