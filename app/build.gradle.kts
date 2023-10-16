plugins {
    id("com.android.application")
}

android {
    namespace = "com.example.recycle"
    compileSdk = 34

    defaultConfig {
        applicationId = "com.example.recycle"
        minSdk = 24
        targetSdk = 34
        versionCode = 1
        versionName = "1.0"

        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
    }

    buildTypes {
        release {
            isMinifyEnabled = false
            proguardFiles(getDefaultProguardFile("proguard-android-optimize.txt"), "proguard-rules.pro")
        }
    }
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_1_8
        targetCompatibility = JavaVersion.VERSION_1_8
    }
}

dependencies {


    implementation("com.google.android.material:material:1.10.0")
    implementation("androidx.constraintlayout:constraintlayout:2.1.4")
    implementation ("androidx.appcompat:appcompat:1.0.0")
    implementation ("androidx.core:core-ktx:1.0.0")

//circle image
    implementation ("de.hdodenhof:circleimageview:3.0.1")
//glide
    implementation ("com.github.bumptech.glide:glide:4.8.0")
    implementation("androidx.recyclerview:recyclerview:1.3.0")
    annotationProcessor ("com.github.bumptech.glide:compiler:4.8.0")

    testImplementation("junit:junit:4.13.2")
    androidTestImplementation("androidx.test.ext:junit:1.1.5")
    androidTestImplementation("androidx.test.espresso:espresso-core:3.5.1")
}