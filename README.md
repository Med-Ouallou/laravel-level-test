---
marp: true
theme: default
paginate: true
title: Player Score
author: Mohamed Ouallou
style: |
  img {
    max-width: 100%;
    display: block;
    margin:  0em auto;
    border-radius: 8px;
  }

---

# Player Score  
### Application de gestion des scores des joueurs

---

## Contexte – Player Score

Le projet **Player Score** permet de centraliser les informations liées aux joueurs de suivre l’évolution de leurs performances.

<img src="./image/2tup.png" class="img-1">

---

## Objectifs du projet

- Comprendre la **conception générique** d’une application CRUD  
- Séparer la **partie fonctionnelle** de la **réalisation technique**  
- Mettre en pratique les opérations :
  - Ajouter
  - Lire
  - Modifier
  - Supprimer
- Respecter une **méthodologie structurée (2TUP)**

---

## Besoin – Analyse Technique

### __Technologies a Utilisées__
1. **Base de données** : MySQL.
2. **Architecture N-tiers** : Services.
3. **Framework** : Laravel.
4. **Architecture** : MVC.
5. **Moteur de vue** : Blade.
---
6. **AJAX** : Interactions dynamiques sans rechargement.
7. **Upload Image** : upload d'images.
8. **Laravel multi-lang** : Interface multilingue.
9. **Vite** : L'outil de construction moderne.
10. **Preline** : Gestion des composants UI.
11. **Tailwind CSS** : Framework CSS utilitaire.
12. **CSS** : Tailwind CSS.
---

## Analyse Fonctionnelle

L’application est basée sur deux types d’acteurs :

- **Visiteur (Public)**.
- **Administrateur**.

![Use Case Diagram](./image/usecase.png)

---

## Conception















































<!-- 
L’application est basée sur deux types d’acteurs :

- **Utilisateur (Public)**
- **Administrateur**

Chaque acteur dispose de fonctionnalités spécifiques.

---

## Acteur : Utilisateur (Public)

L’utilisateur public peut :

- Consulter la liste des joueurs
- Voir le score de chaque joueur
- Rechercher un joueur par :
  - Nom
  - Équipe
- Consulter les scores avec **pagination**

---

## Acteur : Administrateur (Admin)

L’administrateur peut :

- Ajouter un nouveau joueur
- Modifier les informations d’un joueur
- Supprimer un joueur
- Consulter la liste complète des joueurs
- Rechercher un joueur
- Gérer l’affichage avec **pagination** -->
