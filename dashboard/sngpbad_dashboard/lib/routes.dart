import 'package:flutter/material.dart';
import 'package:sngpbad_dashboard/authentification/login.dart';
import 'package:sngpbad_dashboard/authentification/register.dart';
import 'package:sngpbad_dashboard/dashboard.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/screens/accueille.dart';
import 'package:sngpbad_dashboard/screens/fluxFinancier_screen.dart';
import 'package:sngpbad_dashboard/screens/marche_screen.dart';
import 'package:sngpbad_dashboard/screens/pistesAudits_screen.dart';
import 'package:sngpbad_dashboard/screens/projetList_screen.dart';
import 'package:sngpbad_dashboard/screens/setting.dart';
import 'package:sngpbad_dashboard/screens/alerts_risks.dart';


class AppRoutes {
  static const String login = '/';
  static const String register = '/register';
  static const String dashboard = '/dashboard';
  static const String profile = '/profile';
  static const String settings = '/settings';
  static const String accueil = '/accueil';
  static const String statistiques = '/statistiques';
  static const String alertrisk = '/alertrisk';
  static const String projetlist = '/projetlist';
  static const String fluxfinanciers = '/fluxfinanciers';
  static const String marche = '/marche';
  static const String pistesaudits = '/pistesaudits';

  static Map<String, WidgetBuilder> getRoutes() {
    return {
      login: (context) => const Login(),
      register: (context) => const Register(),
      settings: (context) => const Setting(),
      accueil: (context) => const Accueille(userName: ''),
      alertrisk: (context) => const AlertsRisks(),
      projetlist: (context) => const ProjectListScreen(),
      fluxfinanciers: (context) => const FluxFinancierScreen(),
      marche: (context) => const MarcheScreen(),
      pistesaudits: (context) => const PistesAuditsScreen(),
    };
  }

  static Route<dynamic> onGenerateRoute(RouteSettings settings) {
    switch (settings.name) {
      case dashboard:
        if (settings.arguments is UserModel) {
          return MaterialPageRoute(
            builder: (context) => Dashboard(user: settings.arguments as UserModel),
          );
        }
        return _errorRoute();
      case profile:
        if (settings.arguments is UserModel) {
          return MaterialPageRoute(
            builder: (context) => Profile(user: settings.arguments as UserModel),
          );
        }
        return _errorRoute();
      default:
        return MaterialPageRoute(builder: (context) => const Login());
    }
  }

  static Route<dynamic> _errorRoute() {
    return MaterialPageRoute(
      builder: (context) => const Scaffold(
        body: Center(child: Text("Erreur : Utilisateur non authentifié")),
      ),
    );
  }
}
