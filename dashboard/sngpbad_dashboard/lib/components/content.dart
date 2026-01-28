import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/routes.dart';
import 'package:sngpbad_dashboard/screens/accueille.dart';
import 'package:sngpbad_dashboard/screens/audit.dart';
import 'package:sngpbad_dashboard/screens/contrat.dart';
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

class Content extends StatefulWidget {
  final UserModel user;
  final String sectionTitle;

  const Content({super.key, required this.user, required this.sectionTitle});

  @override
  State<Content> createState() => _ContentState();
}

class _ContentState extends State<Content> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color backgroundGrey = const Color(0xFFF4F7F6);

  @override
  Widget build(BuildContext context) {
    return Container(
      color: backgroundGrey,
      padding: const EdgeInsets.all(30),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            _getDisplayTitle(),
            style: GoogleFonts.montserrat(fontSize: 24, fontWeight: FontWeight.bold, color: primaryBlue),
          ),
          const SizedBox(height: 20),
          Expanded(child: _buildSectionContent()),
        ],
      ),
    );
  }

  Widget _buildSectionContent() {
    switch (widget.sectionTitle) {
      case AppRoutes.accueil: return Accueille(userName: widget.user.name);
      case AppRoutes.statistiques: return const Statistic();
      case AppRoutes.profile: return Profile(user: widget.user);
      case AppRoutes.settings: return const Setting();
      case AppRoutes.budget: return const BudgetExecution();
      case AppRoutes.projets: return const ProjectProgress();
      case AppRoutes.alertrisk: return const AlertsRisks();
      case AppRoutes.rapport: return const Rapport();
      case AppRoutes.marches: return const MarketTracking();
      case AppRoutes.secteurs: return const SectorPerformance();
      case AppRoutes.audit: return const Audit();
      case AppRoutes.download: return const Download();
      case AppRoutes.messages: return const Messages();
      case AppRoutes.contrat: return const Contrat();
      case AppRoutes.planning: return const Planning();
      case AppRoutes.suiviTravaux: return const SuiviTravaux();
      
      default: return _buildAutreVue();
    }
  }

  String _getDisplayTitle() {
    if (widget.sectionTitle == AppRoutes.accueil) return "Accueil";
    if (widget.sectionTitle == AppRoutes.statistiques) return "Statistiques";
    if (widget.sectionTitle == AppRoutes.profile) return "Mon Profil";
    if (widget.sectionTitle == AppRoutes.settings) return "Paramètres";
    if (widget.sectionTitle == AppRoutes.budget) return "Exécution Budgétaire";
    if (widget.sectionTitle == AppRoutes.projets) return "Avancement Projets";
    if (widget.sectionTitle == AppRoutes.alertrisk) return "Alertes & Risques";
    if (widget.sectionTitle == AppRoutes.rapport) return "Rapports Officiels";
    if (widget.sectionTitle == AppRoutes.marches) return "Suivi des Marchés";
    if (widget.sectionTitle == AppRoutes.secteurs) return "Performance Sectorielle";
    if (widget.sectionTitle == AppRoutes.audit) return "Audit Financier";
    if (widget.sectionTitle == AppRoutes.download) return "Téléchargements";
    if (widget.sectionTitle == AppRoutes.messages) return "Messages";
    if (widget.sectionTitle == AppRoutes.contrat) return "Contrats";
    if (widget.sectionTitle == AppRoutes.planning) return "Planning & Délais";
    return "Section";
  }

  Widget _buildAutreVue() {
    return Center(child: Text("Contenu pour : ${widget.sectionTitle}"));
  }
}