# Eco Analyse

In order to generalize the use of Life Cycle Assessment (LCA) within the laboratory, as well as to allow a better understanding of its concepts and features, we propose a prototype tool called EcoAnalyse. This tool allows for the realization of simplified LCAs on analytical methods, using parameters that require quick data collection or are available in the "materials and methods" sections of analytical chemistry publications.

The objective of this tool, at this stage, is not to be exhaustive and as complete as possible in terms of inventory data, but to provide users with a quick and quantitative estimate of their analytical methods based on a standardized and objective calculation methodology.

In this sense, the tool distinguishes itself from the published greenness tools, and also allows for visualizing which element and which step of the analysis contribute the most to environmental impacts.

Demo : [https://ecoanalyse.lelabodurable.com](https://ecoanalyse.lelabodurable.com)

## Overview

![Main Screen](https://github.com/Analytiss/eco-analyse/blob/main/resources/images/screen.png?raw=true)

## Configuration

1. Create the .env.dev
   ```shell
   cp .env.example .env.dev
   ```
2. Modify the database information
3. Modify the administrator and user login credentials

## Installation

1. Ensure you have **Docker** and **GNU Make**
    * To verify Docker is installed, run the following command in a terminal:
      ```shell
      docker --version
      ```
    * To verify GNU Make is installed, run the following command in a terminal:
      ```shell
      make --version
      ```
2. Clone the project from the Git repository using the git clone command:
   ```shell
   git clone https://github.com/Analytiss/eco-analyse.git
   ```
3. Use GNU Make to perform the installation tasks:
    * Go to the project directory in a terminal:
      ```shell
      cd eco-analyse
      ```
    * [Configure the project](#configuration)
    * Install dependencies:
      ```shell
       make boot upgrade
      ```
4. Launch the site:
   ```shell
   make start
   ```
5. Access the site at the URL: [localhost](http://localhost)
    * *The requested login credentials are those specified during the configuration*

## Data Initialization

The addition and updating of data is done with the import of CSV files directly on the site.

The import takes place in 2 stages:

1. Importing labels (./resources/csv/label)
   ```csv
   code;name
   code_1;name_1
   code_2;name_2
   code_X;name_X
   ```   
2. Importing values (./resources/csv/value)
    * The first field corresponds to the code present in the label
    * For each impact category, the code of the category must be added in the header, and then its value in the corresponding row
    * Example for the `impact_vategory_label.csv` file
      ```csv
      code;name;unit;name_fr
      category_A;Category A; kg CO2 eq;Catégorie A
      category_B;Category B; kg CO2 eq;Catégorie B
      ```
    * Example for the `country_label.csv` file
      ```csv
      code;name
      FR;France
      IT;Italy
      ES;Spain
      ```
    * Example for the  `electrivity.csv` file
      ```csv
      code;category_A;category_B
      FR;0.56;0.23
      IT;0.65;0.32
      ES;0.4 5;0.54
      ```

URL for data import: [localhost/admin/import](http://localhost/admin/import)

## Contribution

1. [Fork](https://github.com/Analytiss/eco-analyse/fork) the project.
2. Create a branch for your contribution (`git checkout -b feature/ma_fonctionnalité`).
3. Make your changes and commit (`git commit -m 'Ajout de ma fonctionnalité'`).
4. Push your changes to the branch (`git push origin feature/ma_fonctionnalité`).
5. Open a pull request

## Licence

Copyright 2023 Analytiss

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
---

> Project carried out as part of Bastien Raccary's PhD thesis with the University of Bordeaux and the company Analytiss.

[![WEBSITE](https://img.shields.io/website-up-down-green-red/http/analytiss.com.svg)](https://lelabodurable.com)
![Download](https://img.shields.io/github/downloads/Analytiss/eco-analyse/total.svg)

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JS](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![BOOSTRAP](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

[![LINKEDIN](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/company/le-labo-durable/)