# Exercise

## Resumen

Es un entrenador personal ([Trainer]) para aquellas personas que están entrando al mundo del fitness.

## Conceptos

-   Workout (Entrenamiento)

    Es el entrenamiento básico (planchas, sentadillas, etc).

-   Routine (Rutina diaria)

    Conjunto de ejercicios a ejecutar de manera secuencial.

-   Guide (Guiá)

    Es la programación de las rutinas.

## Características

Para facilitar las sesiones de fitness, [Trainer] te ayuda a:

-   **Recomendarte entrenamiento según tus condiciones (físicas) o las ganas**:

    Mediante un quiz se recolectara información del usuario para poder ofrecerle entrenamientos adecuados. Nivel de dificultad, variación o según ubicación donde se encuentra haciendo el entrenamiento (trabajo, gym, hogar, etc).

    También se agregaran entrenamientos según animes, películas, etc. Ejemplo el entrenamiento de one punch man o retos.

-   **Crear entrenamientos personalizados**:

    Cuando el usuario tenga experiencia en fitness podrá crear sus propios entrenamientos y compartilos con los demás.

-   **Ejecución de los entrenamientos**:

    [Trainer] te guiara durante toda la sesión del entrenamiento mostrándote como se realiza (ilustraciones, videos, etc), los tiempos (ejecución y descanso), frases para alentar, entre otros.

    Posiblemente se agregaran modos al [Trainer], ejemplo, [Trainer] sera mas agresivo llamandote gordo, [Trainer] que suene robotics pero divertido o cosas por el estilo si es que el usuario lo decide.

    Challenge mode, se ejecutaran todos los ejercicios del entrenamiento según el nivel del reto (principiante, intermedio, difícil), sin limite de tiempo o cosas por el estilo.

-   **Administración de los entrenamientos y resultados**:

    Se registraran todos los entrenamientos realizados y resultados. Se le facilitara el llevar el control de peso, medidas y calorías que consume.

-   **Guiás alimenticias**:

    Mediante un quiz se recolectara información del usuario. Se le notificara que es mejor consultar un nutriologo.

-   **Multiplataforma**:

    Windows, Linux, iOS, Android, Web

## Database

-   difficulties
-   muscles
-   tags
-   goals
-   equipment
-   workouts
    -   workout_id: variation of exercise
    -   cover
    -   name
    -   description
    -   difficulty
-   routines
    -   name
    -   description
    -   difficulty
-   workout_equipment
-   workout_muscle
-   routine_workout
-   guides
-   guide_routine
-   guide_goal

## TODO
