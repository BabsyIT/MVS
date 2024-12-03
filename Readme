### **Komplette Anleitung: Docker-Apps mit Präfix "MVS" auf GitHub Container Registry (GHCR)**

---

## **1. Voraussetzungen**

### **Software**
- [Docker](https://www.docker.com/) und [Docker Compose](https://docs.docker.com/compose/) installiert.
- Ein [GitHub-Account](https://github.com/).
- Zugriff auf das GitHub Repository.

### **GitHub Repository**
Erstelle ein Repository (z. B. `MVS-Project`) auf GitHub, das deine Anwendung und Konfigurationsdateien enthält.

---

## **2. Projektstruktur**

Organisiere dein Projekt mit der folgenden Verzeichnisstruktur:

```
MVS-Project/
│
├── app/                     # Anwendung
│   ├── index.php            # Startseite
│   ├── login.php            # Login-Logik
│   ├── register.php         # Registrierung
│   ├── verify.php           # E-Mail-Verifizierung
│   ├── logout.php           # Logout
│   ├── dashboard.php        # Geschützte Seite
│   ├── db_connection.php    # Datenbankverbindung
│   └── Dockerfile           # Docker-Image der App
│
├── db/                      # Datenbank
│   ├── init.sql             # SQL-Initialisierungsskript
│   └── Dockerfile           # Docker-Image der Datenbank
│
├── docker-compose.yml       # Docker Compose Datei
├── .github/
│   └── workflows/
│       └── docker-build-and-push.yml # GitHub Actions Workflow
├── .env                     # Umgebungsvariablen (lokale Entwicklung)
└── README.md                # Projektbeschreibung
```

---

## **3. Dockerfiles**

### **3.1 App-Dockerfile**
Speichere die Datei als `app/Dockerfile`:

```dockerfile
FROM php:8.2-apache

# Installiere PHP-Erweiterungen
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Arbeitsverzeichnis setzen
WORKDIR /var/www/html

# Kopiere die Anwendung
COPY . /var/www/html

# Setze Dateiberechtigungen
RUN chown -R www-data:www-data /var/www/html

# Exponiere Port 80
EXPOSE 80
```

### **3.2 DB-Dockerfile**
Speichere die Datei als `db/Dockerfile`:

```dockerfile
FROM mysql:8.0

# Kopiere das Initialisierungsskript
COPY init.sql /docker-entrypoint-initdb.d/
```

---

## **4. Docker-Compose Datei**

Speichere die Datei als `docker-compose.yml`:

```yaml
version: '3.9'
services:
  mvs-app:
    image: ghcr.io/<GITHUB_USERNAME>/mvs-app:latest
    container_name: mvs-app-container
    ports:
      - "8080:80"
    environment:
      - DB_HOST=mvs-db
      - DB_USER=${DB_USER}
      - DB_PASSWORD=${DB_PASSWORD}
      - DB_NAME=${DB_NAME}
    depends_on:
      - mvs-db

  mvs-db:
    image: ghcr.io/<GITHUB_USERNAME>/mvs-db:latest
    container_name: mvs-db-container
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    ports:
      - "3306:3306"
```

Ersetze `<GITHUB_USERNAME>` mit deinem GitHub-Benutzernamen.

---

## **5. SQL-Initialisierungsskript**

Speichere die Datei als `db/init.sql`:

```sql
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_verified BOOLEAN DEFAULT FALSE,
    verification_token VARCHAR(255),
    session_token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## **6. GitHub Actions Workflow**

Erstelle die Datei `.github/workflows/docker-build-and-push.yml`:

```yaml
name: Build and Push to GitHub Container Registry

on:
  push:
    branches:
      - main

jobs:
  build-and-push:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout Repository
      uses: actions/checkout@v4

    - name: Log in to GitHub Container Registry
      uses: docker/login-action@v2
      with:
        registry: ghcr.io
        username: ${{ github.actor }}
        password: ${{ secrets.GITHUB_TOKEN }}

    - name: Build and Push App Image
      run: |
        docker build -t ghcr.io/${{ github.repository_owner }}/mvs-app:latest ./app
        docker push ghcr.io/${{ github.repository_owner }}/mvs-app:latest

    - name: Build and Push DB Image
      run: |
        docker build -t ghcr.io/${{ github.repository_owner }}/mvs-db:latest ./db
        docker push ghcr.io/${{ github.repository_owner }}/mvs-db:latest
```

---

## **7. Umgebungsvariablen**

Speichere eine `.env`-Datei mit den Variablen für lokale Entwicklung:

```env
DB_ROOT_PASSWORD=root_password
DB_NAME=members_db
DB_USER=members_user
DB_PASSWORD=members_password
```

Füge `.env` zu `.gitignore` hinzu, damit die Datei nicht ins Repository hochgeladen wird.

---

## **8. Repository hochladen**

1. Initialisiere das Git-Repository lokal:

   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   ```

2. Füge dein Remote-Repository hinzu:

   ```bash
   git remote add origin https://github.com/<GITHUB_USERNAME>/MVS-Project.git
   ```

3. Lade den Code hoch:

   ```bash
   git push -u origin main
   ```

---

## **9. Deployment prüfen**

1. **Workflow-Status:** Gehe zu deinem Repository → **Actions** und prüfe, ob der Workflow erfolgreich durchgelaufen ist.
2. **Container in GHCR:** Gehe zu **Packages → Container registry**, um die Container `mvs-app` und `mvs-db` zu sehen.
3. **Container abrufen:**

   ```bash
   docker pull ghcr.io/<GITHUB_USERNAME>/mvs-app:latest
   docker pull ghcr.io/<GITHUB_USERNAME>/mvs-db:latest
   ```

4. **Lokal starten:** Nutze `docker-compose`:

   ```bash
   docker-compose up -d
   ```

---

## **10. Zugriffskontrolle für GHCR**

Falls du möchtest, dass die Container öffentlich verfügbar sind:

1. Gehe zu deinem Repository → **Packages** → **Container registry**.
2. Wähle den Container aus (z. B. `mvs-app`).
3. Ändere die Sichtbarkeit von **Private** auf **Public**.

---
