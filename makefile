# =========================
# Configuration generale
# =========================

COMPOSE = docker compose
API_DIR = api

.DEFAULT_GOAL := help

# =========================
# Aide
# =========================

help:
	@echo ""
	@echo "Commandes disponibles :"
	@echo ""
	@echo "  make up            Lance la stack Docker"
	@echo "  make down          Arrete la stack Docker"
	@echo "  make build         Build les images"
	@echo ""
	@echo "  make install       Installe les dependances Symfony"
	@echo "  make update        Met a jour les dependances Symfony"
	@echo ""
	@echo "  make new-api       Cree une nouvelle app Symfony (api/)"
	@echo ""
	@echo "  make cc            Vide le cache Symfony"
	@echo "  make console CMD=  Execute une commande Symfony"
	@echo ""
	@echo "  make logs          Logs Docker"
	@echo ""

# =========================
# Docker
# =========================

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

build:
	$(COMPOSE) build

logs:
	$(COMPOSE) logs -f

# =========================
# Composer
# =========================

install:
	$(COMPOSE) run --rm composer install

update:
	$(COMPOSE) run --rm composer update

# =========================
# Symfony
# =========================

new-api:
	$(COMPOSE) run --rm symfony \
		symfony new $(API_DIR) --webapp --no-git

cc:
	$(COMPOSE) run --rm symfony \
		symfony console cache:clear

console:
ifndef CMD
	$(error Usage: make console CMD="cache:clear")
endif
	$(COMPOSE) run --rm symfony \
		symfony console $(CMD)
