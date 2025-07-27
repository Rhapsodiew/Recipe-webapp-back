# Recipe-webapp-back

Back-end de l'application de gestion de recettes.

## Technologie

- Laravel
- PHP
- PostgreSQL ([shéma de la DB](https://github.com/Rhapsodiew/Recipe-webapp-back/blob/main/doc/shema_db.pdf))

## Endpoints de l'api

| Methode | Endpoint | Données requise | Description |
| ------- | -------- | --------------- | ----------- |
| GET | /api/recipes  | NO | Récupère toute les recettes |
| GET | /api/recipe/{id} | NO |  Détail d'une recette |
| GET | /api/recipes/search | { "ingredient" : "Lait" } | Filtre les recettes par rapport à un ingrédient |
| POST | /api/recipes | { "name" : "Cookie", "ingredients" : [{ "name" : "Chocolat"}]} | Créer une nouvelle recette |
| PUT | /api/recipes/{id} | { "name" : "Cookie", "ingredients" : [{ "name" : "Sucre"}]} | Modifier une recette |
| DEL | /api/recipes/{id} | NO | Supprimer une recette |
| GET | /api/ingredients | NO | Récupère tout les ingrédients |
| GET | /api/ingredients/{id} | NO | Détail d'un ingredient |
| POST | /api/ingredients | { "name" : "Huile" } | Créer un nouvelle ingrédient |
| PUT | /api/ingredients/{id} | { "name" : "Levure" } | Modifier un ingrédient |
| DEL | /api/ingredients/{id} | NO | Supprimer un ingrédient |
