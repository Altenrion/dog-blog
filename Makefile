
GITTEXT=$(MSG)


push:
	@echo "Prepare building...setting OS & build..."
	@echo "----------------------------------------"
	git add .
	git commit -m "$(GITTEXT)"
	git push origin master
	@echo "----------------------------------------"

deploy: pack push finish
