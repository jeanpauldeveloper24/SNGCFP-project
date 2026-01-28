import 'package:flutter/material.dart';
import 'package:sngpbad_dashboard/authentification/login.dart';
import 'package:sngpbad_dashboard/authentification/register.dart';
import 'package:sngpbad_dashboard/dashboard.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/screens/accueille.dart';
import 'package:sngpbad_dashboard/screens/audit.dart';
import 'package:sngpbad_dashboard/screens/download.dart';
import 'package:sngpbad_dashboard/screens/messages.dart';
import 'package:sngpbad_dashboard/screens/planning.dart';
import 'package:sngpbad_dashboard/screens/profile.dart';
import 'package:sngpbad_dashboard/screens/setting.dart';
import 'package:sngpbad_dashboard/screens/statistic.dart';
import 'package:sngpbad_dashboard/screens/alerts_risks.dart';
import 'package:sngpbad_dashboard/screens/rapport.dart';
import 'package:sngpbad_dashboard/screens/budget_execution.dart'; 
import 'package:sngpbad_dashboard/screens/project_progress.dart';
import 'package:sngpbad_dashboard/screens/market_tracking.dart';
import 'package:sngpbad_dashboard/screens/sector_performance.dart';
import 'package:sngpbad_dashboard/screens/suivi_travaux.dart';

class AppRoutes {
  static const String login = '/';
  static const String register = '/register';
  static const String dashboard = '/dashboard';
  static const String profile = '/profile';
  static const String settings = '/settings';
  static const String accueil = '/accueil';
  static const String statistiques = '/statistiques';
  static const String rapport = '/rapport';
  static const String alertrisk = '/alertrisk';
  static const String budget = '/budget';
  static const String projets = '/projets';
  static const String marches = '/marches';
  static const String secteurs = '/secteurs';
  static const String audit = '/audit';
  static const String download = '/download';
  static const String messages = '/messages';
  static const String suiviTravaux = '/suivi_travaux';
static const String preuvesMedia = '/preuves_media';
static const String submitInvoice = '/submit_invoice';
static const String planning = '/planning';
static const String paiements = '/paiements';
static const String contrat = '/contrat';

  static Map<String, WidgetBuilder> getRoutes() {
    return {
      login: (context) => const Login(),
      register: (context) => const Register(),
      settings: (context) => const Setting(),
      accueil: (context) => const Accueille(userName: ''),
      statistiques: (context) => const Statistic(),
      rapport: (context) => const Rapport(),
      alertrisk: (context) => const AlertsRisks(),
      budget: (context) => const BudgetExecution(),
      projets: (context) => const ProjectProgress(),
      audit: (context) => const Audit(),
      download: (context) => const Download(),
      marches: (context) => const MarketTracking(),
      secteurs: (context) => const SectorPerformance(),
      messages: (context) => const Messages(),
      planning: (context) => const Planning(),
      suiviTravaux: (context) => const SuiviTravaux(),
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
