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
                // ACCUEIL
                _buildMenuItem(
                  icon: Icons.home_outlined, 
                  title: "Accueil", 
                  sectionId: AppRoutes.accueil, 
                  context: context
                ),

                // MESSAGERIE avec Badge de notification
                _buildMenuItem(
                  icon: Icons.chat_bubble_outline_rounded, 
                  title: "Messagerie Interne", 
                  sectionId: AppRoutes.messages, 
                  context: context,
                  hasNotification: true, // Simulation d'une notification
                ),

                const Divider(color: Colors.white24, indent: 20, endIndent: 20),

                // MENUS DYNAMIQUES (Basés sur le rôle)
                ..._buildDynamicMenus(context),
                
                const Divider(color: Colors.white24, indent: 20, endIndent: 20),
                
                // PARAMÈTRES
                _buildMenuItem(
                  icon: Icons.settings_outlined, 
                  title: "Paramètres", 
                  sectionId: AppRoutes.settings,
                  context: context
                ),
              ],
            ),
          ),

          const Divider(color: Colors.white24),
          
          // BOUTON DÉCONNEXION
          _buildMenuItem(
            icon: Icons.logout, 
            title: "Déconnexion", 
            sectionId: AppRoutes.login,
            isLogout: true, 
            context: context
          ),

          // MINI-FOOTER DE SUPPORT
          Padding(
            padding: const EdgeInsets.symmetric(vertical: 20, horizontal: 20),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text(
                  "Besoin d'aide ?",
                  style: TextStyle(color: Colors.white54, fontSize: 10, fontWeight: FontWeight.bold),
                ),
                const SizedBox(height: 4),
                const Text(
                  "support-sngp@bad.org",
                  style: TextStyle(color: Colors.white38, fontSize: 10),
                ),
                const SizedBox(height: 10),
                const Text(
                  "SNGP-BAD v1.0.0",
                  style: TextStyle(color: Colors.white24, fontSize: 9),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  List<Widget> _buildDynamicMenus(BuildContext context) {
    List<Widget> menus = [];

    if (user.role != UserRole.externalAuditor) {
      menus.add(
        _buildMenuItem(
          icon: Icons.analytics_outlined, 
          title: "Statistiques", 
          sectionId: AppRoutes.statistiques, 
          context: context
        )
      );
    }

    switch (user.role) {
      case UserRole.badRepresentative:
        menus.addAll([
          _buildMenuItem(icon: Icons.account_balance_wallet_outlined, title: "Exécution Budgétaire", sectionId: AppRoutes.budget, context: context),
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Avancement Projets", sectionId: AppRoutes.projets, context: context),
          _buildMenuItem(icon: Icons.warning_amber_rounded, title: "Alertes & Risques", sectionId: AppRoutes.alertrisk, context: context),
          _buildMenuItem(icon: Icons.description_outlined, title: "Rapports", sectionId: AppRoutes.rapport, context: context),
        ]);
        break;

      case UserRole.ministryOfTutelle:
        menus.addAll([
          _buildMenuItem(icon: Icons.assignment_outlined, title: "Suivi des Marchés", sectionId: AppRoutes.marches, context: context),
          _buildMenuItem(icon: Icons.trending_up, title: "Performance Sectorielle", sectionId: AppRoutes.secteurs, context: context),
        ]);
        break;

      case UserRole.externalAuditor:
        menus.addAll([
          _buildMenuItem(icon: Icons.fact_check_outlined, title: "Audit Financier", sectionId: AppRoutes.audit, context: context),
          _buildMenuItem(icon: Icons.download_for_offline_outlined, title: "Téléchargement", sectionId: AppRoutes.download, context: context),
        ]);
        break;

      case UserRole.prestataire:
        menus.addAll([
          _buildMenuItem(icon: Icons.construction_rounded, title: "Suivi des Travaux", sectionId: AppRoutes.suiviTravaux, context: context),
          _buildMenuItem(icon: Icons.request_quote_outlined, title: "Soumettre une Facture", sectionId: AppRoutes.submitInvoice, context: context),
          _buildMenuItem(icon: Icons.event_note_outlined, title: "Planning & Délais", sectionId: AppRoutes.planning, context: context),
          _buildMenuItem(icon: Icons.payments_outlined, title: "Paiements", sectionId: AppRoutes.paiements, context: context),
          _buildMenuItem(icon: Icons.gavel_rounded, title: "Contrat", sectionId: AppRoutes.contrat, context: context),
        ]);
        break;
      
      default: break;
    }
    return menus;
  }

  Widget _buildMenuItem({
    required IconData icon, 
    required String title, 
    required String sectionId,
    bool isLogout = false, 
    bool hasNotification = false,
    required BuildContext context
  }) {
    return ListTile(
      leading: Stack(
        children: [
          Icon(icon, color: isLogout ? errorRed : Colors.white70, size: 22),
          if (hasNotification)
            Positioned(
              right: 0,
              top: 0,
              child: Container(
                padding: const EdgeInsets.all(1),
                decoration: BoxDecoration(
                  color: Colors.red,
                  borderRadius: BorderRadius.circular(6),
                ),
                constraints: const BoxConstraints(minWidth: 8, minHeight: 8),
              ),
            ),
        ],
      ),
      title: Text(
        title, 
        style: GoogleFonts.inter(
          color: isLogout ? errorRed : Colors.white, 
          fontSize: 13,
          fontWeight: isLogout || hasNotification ? FontWeight.bold : FontWeight.normal
        )
      ),
      onTap: () {
        if (isLogout) {
          Navigator.pushReplacementNamed(context, AppRoutes.login); 
        } else {
          onSectionSelected(sectionId);
        }
      },
    );
  }

  Widget _buildLogoSection() {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 40),
      child: Column(
        children: [
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 15, vertical: 8),
            decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(8)),
            child: Text("LOGO BAD", style: TextStyle(fontWeight: FontWeight.bold, color: primaryBlue)),
          ),
          const SizedBox(height: 10),
          Text("SNGP-BAD", style: GoogleFonts.montserrat(color: Colors.white, fontSize: 18, fontWeight: FontWeight.bold)),
        ],
      ),
    );
  }
}