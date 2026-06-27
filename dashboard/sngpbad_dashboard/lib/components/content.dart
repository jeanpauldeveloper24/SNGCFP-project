import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/routes.dart';
import 'package:sngpbad_dashboard/screens/accueille.dart';
import 'package:sngpbad_dashboard/screens/setting.dart';
import 'package:sngpbad_dashboard/screens/alerts_risks.dart';

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
      case AppRoutes.profile: return Profile(user: widget.user);
      case AppRoutes.settings: return const Setting();
      case AppRoutes.alertrisk: return const AlertsRisks();
      default: return _buildAutreVue();
    }
  }

  String _getDisplayTitle() {
    if (widget.sectionTitle == AppRoutes.accueil) return "Accueil";
    if (widget.sectionTitle == AppRoutes.profile) return "Mon Profil";
    if (widget.sectionTitle == AppRoutes.settings) return "Paramètres";
    if (widget.sectionTitle == AppRoutes.projets) return "Avancement Projets";
    if (widget.sectionTitle == AppRoutes.alertrisk) return "Alertes & Risques";
  }

  Widget _buildAutreVue() {
    return Center(child: Text("Contenu pour : ${widget.sectionTitle}"));
  }
}