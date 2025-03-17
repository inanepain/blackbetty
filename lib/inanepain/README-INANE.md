# Inanepain Projects

Some simple, basic and other information worth notting for the inanepain libraries.

## Asciidoc

Firstly you need `asciidoctor` but that's not all, `asciidoctor-reducer` is also needed to build the final README files from the sources.

```
gem install asciidoctor-reducer
```

## Gitea

### Package Management

Download the tag from the project page as a zip file. Edit command bellow to point to zip file and version number.

```
curl --user philip:Esoter1c!@ --upload-file "C:\Users\Philip\Downloads\cli-0.15.0.zip" http://localhost:3000/api/packages/inanepain/composer?version=0.15.0
```
