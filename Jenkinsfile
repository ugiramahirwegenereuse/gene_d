pipeline {
    agent any

    environment {
        DOCKER_COMPOSE = "docker-compose"
        APP_URL = "http://localhost:8010/registration.php"
    }

    stages {
        stage('Checkout') {
            steps {
                echo "Cloning repository..."
                git branch: 'main', url: 'https://github.com/ugiramahirwegenereuse/gene_d.git'
            }
        }

        stage('Build & Start Docker') {
            steps {
                echo "Stopping any existing containers..."
                sh "${DOCKER_COMPOSE} down"
                
                echo "Building and starting containers..."
                sh "${DOCKER_COMPOSE} up --build -d"
            }
        }

        stage('Test Application') {
            steps {
                echo "Testing registration page..."
                sh "curl -I ${APP_URL}"
            }
        }
    }

    post {
        always {
            echo 'Pipeline finished.'
            echo 'You may add steps here to cleanup, archive artifacts, or notify.'
        }
        success {
            echo 'Build and test completed successfully!'
        }
        failure {
            echo 'Something went wrong! Check logs above.'
        }
    }
}
