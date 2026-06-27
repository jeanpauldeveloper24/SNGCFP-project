import 'package:flutter/material.dart';
import 'package:sngpbad_dashboard/authentification/login.dart';
import 'package:sngpbad_dashboard/dashboard.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/routes.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
  debugShowCheckedModeBanner: false,
  title: 'SNGP-BAD',
  initialRoute: AppRoutes.login,
  // Remplace ou complète avec ceci :
  onGenerateRoute: (settings) {
    if (settings.name == AppRoutes.dashboard) {
      // On récupère l'utilisateur passé en argument
      final user = settings.arguments as UserModel; 
      return MaterialPageRoute(
        builder: (context) => Dashboard(user: user),
      );
    }
    
    // Tes autres routes standards
    if (settings.name == AppRoutes.login) {
      return MaterialPageRoute(builder: (context) => const Login());
    }
    // ...
    return null;
  },
);
  }
}