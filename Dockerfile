FROM ubuntu:latest
LABEL authors="corina.lozan@internal.ebs.md"

ENTRYPOINT ["top", "-b"]
