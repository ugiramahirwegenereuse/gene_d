pipeline {
    agent any

    environment {
        DOCKER_COMPOSE = "/usr/local/bin/docker-compose" // adjust if needed
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/ugiramahirwegenereuse/gene_d.git'
            }
        }

        stage('Build & Start Docker') {
            steps {
                sh 'docker-compose down'
                sh 'docker-compose up --build -d'
            }
        }

        stage('Test') {
            steps {
                // You can add simple curl test to check PHP app
                sh 'curl -I http://localhost:8010/registration.php'
            }
        }
    }

    post {
        always {
            echo 'Pipeline finished.'
        }
    }
}
