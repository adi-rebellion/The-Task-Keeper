
# Turn down all running containers & services.
docker-compose down

# Pull the latest changes from github.
cd ..
git pull origin staging

# Mode to app
cd app
# Add env for app prod.
cp .env.prod .env
# Remove node-modules & populate.
rm -f -r ./node_modules
npm install
# Build the vue to dist.
npm run build

# Move to backend
cd ../backend
# Add env for backend prod.
cp .env.prod .env
# Re-populate vendor folder.
rm -f -r ./vendor
composer install

# Build the docker images and start the containers.
cd ../infra
docker-compose up -d

sleep 30

# Check the application status.
curl -o /dev/null -s -w "%{http_code}\n" http://stage.hearecho.com # Should be 200
curl -o /dev/null -s -w "%{http_code}\n" http://api-stage.hearecho.com # Should be 404
