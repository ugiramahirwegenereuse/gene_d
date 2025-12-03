pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                echo 'stage running'
                checkout scm
            }
        }
        stage('Build') {
            steps {
                echo 'stage running'
                sh 'docker-compose -f docker-compose.yml build'
            }
        }
        stage('Test') {
            steps {
                echo 'stage running'
                // placeholder: you could run PHP linter or unit tests
                sh 'php -l src/index.php || true'
            }
        }
        stage('Dockerize') {
            steps {
                echo 'stage running'
                sh 'docker-compose -f docker-compose.yml up -d --build'
            }
        }
        stage('Deploy') {
            steps {
                echo 'stage running'
                // placeholder deploy step
                echo "Deployment step (placeholder)"
            }
        }
    }
    post {
        always {
            echo 'Pipeline finished'
        }
    }
}
