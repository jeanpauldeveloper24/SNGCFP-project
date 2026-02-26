import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/models/user_model.dart';
import 'package:sngpbad_dashboard/routes.dart';

class AppDrawer extends StatelessWidget {
  final UserModel user;
  final Function(String) onSectionSelected;

  const AppDrawer({super.key, required this.user, required this.onSectionSelected});

  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color errorRed = const Color(0xFFE74C3C);

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 280,
      color: primaryBlue,
      child: Column(
        children: [
          _buildLogoSection(),
          Expanded(
            child: ListView(
              padding: EdgeInsets.zero,
              children: [
                _buildMenuItem(icon: Icons.home_outlined, title: "Accueil", sectionId: AppRoutes.accueil, context: context),
                _buildMenuItem(icon: Icons.person_outline, title: "Mon Profil", sectionId: AppRoutes.profile, context: context),
                _buildMenuItem(icon: Icons.chat_bubble_outline_rounded, title: "Messagerie", sectionId: AppRoutes.messages, context: context, hasNotification: true),
                
                const Divider(color: Colors.white24, indent: 20, endIndent: 20),

                // MENUS DYNAMIQUES
                ..._buildDynamicMenus(context),
                
                const Divider(color: Colors.white24, indent: 20, endIndent: 20),
                _buildMenuItem(icon: Icons.settings_outlined, title: "Paramètres", sectionId: AppRoutes.settings, context: context),
              ],
            ),
          ),
          const Divider(color: Colors.white24),
          _buildMenuItem(icon: Icons.logout, title: "Déconnexion", sectionId: AppRoutes.login, isLogout: true, context: context),
          _buildFooter(),
        ],
      ),
    );
  }

  List<Widget> _buildDynamicMenus(BuildContext context) {
    List<Widget> menus = [];

    if (user.roleName != 'externalAuditor') {
      menus.add(_buildMenuItem(icon: Icons.analytics_outlined, title: "Statistiques", sectionId: AppRoutes.statistiques, context: context));
    }

    switch (user.roleName) {
      case 'badRepresentative':
        menus.addAll([
          _buildMenuItem(icon: Icons.account_balance_wallet_outlined, title: "Exécution Budgétaire", sectionId: AppRoutes.budget, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Avancement Projets", sectionId: AppRoutes.projets, context: context),
          _buildMenuItem(icon: Icons.warning_amber_rounded, title: "Alertes & Risques", sectionId: AppRoutes.alertrisk, context: context),
        ]);
        break;
      case 'nationalDirection':
        menus.addAll([
          _buildMenuItem(icon: Icons.gavel_rounded, title: "Passation des Marchés", sectionId: AppRoutes.marches, context: context),
          _buildMenuItem(icon: Icons.track_changes_outlined, title: "Suivi des Réalisations", sectionId: AppRoutes.projets, context: context),
        ]);
        break;
      case 'prestataire':
        menus.addAll([
          _buildMenuItem(icon: Icons.construction_rounded, title: "Rapport des Travaux", sectionId: AppRoutes.rapportTravaux, context: context),
          _buildMenuItem(icon: Icons.payments_outlined, title: "Paiements", sectionId: AppRoutes.paiements, context: context),
        ]);
        break;
    }
    return menus;
  }

  Widget _buildMenuItem({required IconData icon, required String title, required String sectionId, bool isLogout = false, bool hasNotification = false, required BuildContext context}) {
    return ListTile(
      leading: Icon(icon, color: isLogout ? errorRed : Colors.white70, size: 22),
      title: Text(title, style: GoogleFonts.inter(color: isLogout ? errorRed : Colors.white, fontSize: 13)),
      onTap: () => isLogout ? Navigator.pushReplacementNamed(context, AppRoutes.login) : onSectionSelected(sectionId),
    );
  }

  Widget _buildLogoSection() {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 40),
      child: Column(
        children: [
          Container(
            padding: const EdgeInsets.all(8),
            decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(8)),
            child: Text("LOGO BAD", style: TextStyle(fontWeight: FontWeight.bold, color: primaryBlue)),
          ),
          const SizedBox(height: 10),
          Text("SNGP-BAD", style: GoogleFonts.montserrat(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold)),
        ],
      ),
    );
  }

  Widget _buildFooter() {
    return const Padding(
      padding: EdgeInsets.all(20),
      child: Text("v1.0.0", style: TextStyle(color: Colors.white24, fontSize: 9)),
    );
  }
}