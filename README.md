# 💬 Chat-PHP – Déploiement Docker & CI/CD avec Dokploy

Ce projet est une application **Chat en PHP** connectée à une base de données **MariaDB**, déployée automatiquement grâce à **GitHub Actions** et **Dokploy**.

Il illustre :
- La mise en place d’un environnement **Docker multi-services**
- L’utilisation d’un **réseau Docker Swarm** pour la communication inter-containers
- L’automatisation du **build, push et déploiement** via un pipeline CI/CD

---

## 📂 Arborescence du projet


Chat-PHP/
│
├── docker-compose.yml                               
│   
├── src/
│   ├── index.php 
├── .github/                      
│      └── workflows/
│          └── deploy.yml            
│                      
├──  Dockerfile                          
├── README.md                  


