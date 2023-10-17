help:
	@echo "usage: make [Target]"
	@echo ""
	@echo "Targets:"
	@echo "  help      Show this help"
	@echo "  up        Start development server"
	@echo "  serve     Serve development server"
	@echo "  down      Stop development server"
	@echo "  logs      Show development server logs"
	@echo "Targets after 'make up':"
	@echo "  db        Migrate refresh and seed database"
	@echo "  cache     Clear all caches and remake"

up:
	@docker-compose up -d
	@php artisan serve

serve:
	@php artisan serve

down:
	@docker-compose down

logs:
	@docker-compose logs -f

db:
	@php artisan db:seed

cache:
	@php artisan config:clear
	@php artisan cache:clear
	@php artisan route:clear
	@php artisan view:clear
	@php artisan config:cache
	@php artisan route:cache
	@php artisan view:cache