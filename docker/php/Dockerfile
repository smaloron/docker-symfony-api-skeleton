# Image de base :
# PHP 8.5 avec PHP-FPM (pour Nginx) sur Alpine Linux (léger et rapide)
FROM php:8.5-fpm-alpine


# Définit le répertoire de travail par défaut dans le conteneur
# Toutes les commandes suivantes s'exécutent depuis /srv/app
WORKDIR /srv/app


# ==========================================================
# Dépendances runtime
# Nécessaires pour exécuter PHP et Symfony
# ==========================================================

RUN set -eux; \
  \
  # apk est le gestionnaire de paquets Alpine
  # --no-cache évite de stocker l'index localement
  apk add --no-cache \
    bash \
    git \
    curl \
    icu-libs \
    libzip \
    postgresql-libs


# ==========================================================
# Dépendances de build et compilation des extensions PHP
# Ces dépendances seront supprimées après compilation
# ==========================================================

RUN set -eux; \
  \
  # Création d'un méta-paquet temporaire ".build-deps"
  apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    icu-dev \
    libzip-dev \
    postgresql-dev \
    linux-headers \
  ; \
  \
  # Compilation des extensions PHP officielles
  # -j$(nproc) active la compilation parallèle
  docker-php-ext-install -j"$(nproc)" \
    intl \
    pdo_pgsql \
    pgsql \
    zip \
  ; \
  \

  # Installation de APCu via PECL (cache mémoire PHP)
  pecl install apcu; \
  docker-php-ext-enable apcu; \
  \

  # Installation de Xdebug (version fixée pour la stabilité)
  pecl install xdebug-3.5.0; \
  docker-php-ext-enable xdebug; \
  \

  # Suppression des dépendances de build
  apk del .build-deps


# ==========================================================
# Installation de Composer
# Copie depuis l'image officielle Composer (multi-stage)
# ==========================================================

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer


# ==========================================================
# Installation de Symfony CLI
# ==========================================================

# Télécharge et installe Symfony CLI via le script officiel
RUN curl -sS https://get.symfony.com/cli/installer | bash \
  \
  # Déplacement du binaire dans un répertoire du PATH
  && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony


# ==========================================================
# Configuration PHP
# ==========================================================

# Copie des fichiers de configuration PHP (.ini)
# Le dossier conf.d est automatiquement chargé par PHP
COPY ./conf.d/ /usr/local/etc/php/conf.d/


# ==========================================================
# Création d'un utilisateur non-root
# ==========================================================

RUN set -eux; \
  \
  # Création du groupe "app" (GID 1000)
  addgroup -g 1000 -S app; \
  \
  # Création de l'utilisateur "app" (UID 1000)
  adduser -u 1000 -S app -G app; \
  \
  # Attribution des droits sur le dossier applicatif
  chown -R app:app /srv/app


# ==========================================================
# Exécution du conteneur en utilisateur non-root
# ==========================================================

# Toutes les commandes et PHP-FPM s'exécutent avec l'utilisateur "app"
USER app
