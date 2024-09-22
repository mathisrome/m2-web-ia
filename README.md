# Démarrage du projet

Lancer la commande suivante :

```shell
docker compose up -d && \
docker compose exec symfony-php composer install
```

# Mise à jour des données de test

Lancer la commande suivante :

```shell
docker compose exec symfony-php php bin/console d:f:l
```

# Rendu

Vous trouverez le rendu du DM dans le fichier `python/rendu.ipynb`

Toute l'infrastructure est automatiquement lancée via la commande de démarrage ci-dessus.
