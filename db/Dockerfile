# Multi-Arch-Unterstützung hinzufügen
ARG TARGETPLATFORM
FROM --platform=$TARGETPLATFORM mysql:8.0

# Kopiere Initialisierungs-Skript in das MySQL-Init-Verzeichnis
COPY init.sql /docker-entrypoint-initdb.d/

# Exponiere Standard-MySQL-Port
EXPOSE 3306
