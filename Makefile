
GITTEXT=$(MSG)

build:
	@echo "Building container..."
	docker build -t dog-blog .
	@echo "Run container for local tests..."
	docker run --name=dog-blog-doc -it --rm -p 80:80 dog-blog

push:
	@echo "Prepare building...setting OS & build..."
	@echo "----------------------------------------"
	git add .
	git commit -m "$(GITTEXT)"
	git push origin master
	@echo "----------------------------------------"

deploy: pack push finish
