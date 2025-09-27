rm -rf dist/*
cd src/frontend
ng build
cd ../..
cp -r backend/src/* dist/backend/*
cp nova.json dist/nova.json
